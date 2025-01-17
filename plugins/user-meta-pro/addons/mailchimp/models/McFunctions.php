<?php
namespace UserMeta\MailChimp;

require_once(Base::addonData('path').'/resources/vendor/MailChimp.php');

use \DrewM\MailChimp\MailChimp;

/**
 * Different functions syncing with Mailchimp
 *
 * @since 2.5
 * @author khaled Hossain
 */
class McFunctions
{
    private $apiKey;
    private $mailChimp;
    private $isValid = false;

    /**
     * Create a new instance
     * Check if the connection is valid
     */
    function __construct()
    {
        $this->apiKey = !empty(Base::getData()['api_key']) ? Base::getData()['api_key'] : '';
        $this->mailChimp = !empty($this->apiKey) ? new MailChimp($this->apiKey) : '';
        $this->isValid = !empty($this->mailChimp) && !empty($this->mailChimp->get('lists')['lists']);
    }

    /**
     * Get the status of the connection
     * @return string status
     */
    public function getStatus(){
        if($this->isValid){ return __('Connected', 'user-meta');}
        if(empty($this->apiKey)){ return __('Empty API Key', 'user-meta');}
        if(empty($this->mailChimp->isValid)){ return __('Invalid Key Supplied', 'user-meta');}
        if(!empty($this->mailChimp->get('lists')['detail'])){ return $this->mailChimp->get('lists')['detail'];}
        return __('Not Connected (check your connection and key)', 'user-meta');
    }

    /**
     * Get the list
     * @return array
     */
    private function getList(){
        return $this->isValid ? $this->mailChimp->get('lists')['lists'] : [];
    }

    /**
     * Get list html
     * @return string of html
     */
    public function getListHtml(){
        if(!$this->isValid){ return '';}
        $html = '<br><br><strong>List</strong><br>';
        $list = $this->getList();
        if(empty($list)){ return $html;}
        foreach($list as $element){
            $html .= '&emsp;<strong>- '.esc_html($element['name']).'</strong> (ID: '.esc_html($element['id']).', Subscribers: '.esc_html($element['stats']['member_count']).')<br>';
        }
        return $html;
    }

    /**
     * Subscribe user to mailchimp
     * @param $field
     * @param $user
     * @param bool $registration
     */
    public function subscribe($field, $user, $registration=true){
        $email = $user->user_email;
        $action = $registration ? 'Add' : 'Update';

        if(!$this->isValid){
            $this->writeLogs('None', $action, $email, 'Failure', 'Invalid Mailchimp setup! Wrong API key or no list found!');
            return;
        }

        $listMethod = isset($field['list_selection_method']) ? $field['list_selection_method'] : 'field';
        $listValue = ($listMethod != 'field') ? (isset($field['list_selection_text']) ? $field['list_selection_text'] : '') :
            (isset($field['list_selection_field']) ? $user->{$field['list_selection_field']} : '');
        $lists = is_array($listValue) ? $listValue : explode(',',$listValue);
        $status = isset($field['subscription_without_permission']) ? 'subscribed' : 'pending';
        $mergeFields = isset($field['merge_fields']) ? (new FieldOptions)->getMergeValues($field['merge_fields'], $user) : [];
        $tags = $this->getTagsValue($field, $user);
        $subscriberHash = $this->getHash($email);

        if(empty($lists) || empty($email)){
            $this->writeLogs('None', $action, $email, 'Failure', 'No list found with provided list in setup');
            return;
        }

        foreach ($lists as $id) {
            $listID = trim($id);
            if($registration) {
                $result = $this->mailChimp->post("lists/$listID/members", [
                    'email_address' => $email,
                    'status' => $status
                ]);
            }

            if(!empty($mergeFields)) {
                $result = $this->mailChimp->patch("lists/$listID/members/$subscriberHash", [
                    'merge_fields' => $mergeFields
                ]);
            }

            foreach ($tags as $tag) {
                $result = $this->mailChimp->post("lists/$listID/members/$subscriberHash/tags", [
                    'tags' => [
                        ['name' => $tag, 'status' => 'active']
                    ]
                ]);
            }

            if ($this->mailChimp->success()) {
                $successStatus = ($status == 'subscribed') ? 'Success: subscribed' : 'Success: pending for email confirmation';
                $this->writeLogs($listID, $action, $email, $successStatus, 'None');

            } else {
                $this->writeLogs($listID, $action, $email, 'Failure', $this->mailChimp->getLastError());
            }

        }

    }

    public function delete($email)
    {
        if(!$this->isValid){
            $this->writeLogs('None', 'Delete', $email, 'Failure', 'Invalid Mailchimp setup! Wrong API key or no list found!');
            return;
        }

        $subscriberHash = $this->getHash($email);
        $list = $this->getList();
        foreach ($list as $element){
            $listId = $element['id'];
            //get if user exist
            $result = $this->mailChimp->delete("lists/$listId/members/$subscriberHash");

            if ($this->mailChimp->success()) {
                $this->writeLogs($listId, 'Delete', $email, 'Success', 'None');
            } else {
                $this->writeLogs($listId, 'Delete', $email, 'Failure', $this->mailChimp->getLastError());
            }
        }
    }

    public function unsubscribe($email)
    {
        if(!$this->isValid){
            $this->writeLogs('None', 'Unsubscibe', $email, 'Failure', 'Invalid Mailchimp setup! Wrong API key or no list found!');
            return;
        }

        $subscriberHash = $this->getHash($email);
        $list = $this->getList();

        foreach ($list as $element) {
            $listId = $element['id'];
            $result = $this->mailChimp->put("lists/$listId/members/$subscriberHash", [
                'status' => 'unsubscribed'
            ]);

            if ($this->mailChimp->success()) {
                $this->writeLogs($listId, 'Unsubscibe', $email, 'Success', 'None');
            } else {
                $this->writeLogs($listId, 'Unsubscibe', $email, 'Failure', $this->mailChimp->getLastError());
            }
        }
    }

    /**
     * Get tags value
     * @param $field
     * @param $user
     * @return array|mixed
     */
    private function getTagsValue($field, $user){
        $tagMethod = isset($field['tag_selection_method']) ? $field['tag_selection_method'] : 'no';
        if($tagMethod == 'field'){
            return isset($field['tag_selection_field']) ? is_array($user->{$field['tag_selection_field']}) ? $user->{$field['tag_selection_field']} : explode(',', $user->{$field['tag_selection_field']}) : [];
        }
        if($tagMethod == 'text'){
            return isset($field['tag_selection_text']) ? explode(',', $field['tag_selection_text']): [];
        }
        return [];
    }

    /**
     * Get md5 value
     * @param $data
     */
    private function getHash($data)
    {
        return md5(strtolower($data));
    }

    private function writeLogs($list, $action, $email, $outcome, $error) {
        $time = date('d-m-y h:i:s');
        $updateValue = array(
            'time' => $time,
            'list' => $list,
            'email' => $email,
            'action' => $action,
            'outcome' => $outcome,
            'error' => $error
        );
        $logs = get_option('user_meta_addon_mailchimp_logs');
        if(empty($logs)) {
            $logs = [];
        }
        // Store 500 0f latest values
        if(count($logs) > 500){
            array_shift($logs);
        }
        $logs[] = $updateValue;
        update_option('user_meta_addon_mailchimp_logs', \UserMeta\sanitizeDeep($logs));
    }

}