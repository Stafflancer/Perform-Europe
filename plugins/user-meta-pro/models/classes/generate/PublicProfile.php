<?php
namespace UserMeta;

/**
 * Generate public form data
 *
 * @author Sourov Amin
 * @since 3.0
 */

class PublicProfile
{
    protected $formName;
    protected $style;
    protected $call;
    protected $user;
    protected $form;

    function __construct($formName, $call = 'id', $style = 'table')
    {
        $this->formName = $formName;
        $this->style = $style;
        $this->call = $call;
        $this->user = $this->getUser();
        $this->form = !$this->user ? false : $this->formBuilder();
    }

    private function getUser()
    {
        if($this->call == 'email') {
            $user_email = !empty($_REQUEST['user_email']) ? esc_attr($_REQUEST['user_email']) : '';
            return get_user_by('email', $user_email);
        }
        elseif ($this->call == 'username') {
            $username = !empty($_REQUEST['user_login']) ? esc_attr($_REQUEST['user_login']) : '';
            return get_user_by('login', $username);
        }
        else {
            $user_id = !empty($_REQUEST['user_id']) ? esc_attr($_REQUEST['user_id']) : '';
            return get_user_by('id', $user_id);
        }
    }

    private function formBuilder()
    {
        return (new FormGenerate($this->formName, 'profile', $this->user->ID));
    }

    private function getData()
    {
        $data = [];

        $form = $this->form->getForm();

        $fields = $form['fields'];

        foreach ($fields as $key => $field){

            if(in_array($field['field_type'], ['html', 'captcha', 'page_heading', 'section_heading']))
                continue;

            $metaKey = !empty($field['meta_key']) || !empty($field['field_type']) ? (!empty($field['meta_key']) ? $field['meta_key'] : $field['field_type'] ): '';
            $title = !empty($field['field_title']) ? esc_html($field['field_title']): esc_html($metaKey);
            $defaultValue = !empty($field['default_value']) ? $field['default_value'] : '';

            if($field['field_type'] == 'user_avatar') {
                $value = get_avatar($this->user->ID);
            } else {
                $value = !empty($field['field_value']) ? $field['field_value'] : $defaultValue;
                $value = is_array($value) ? esc_html(implode(', ', $value)) : esc_html($value);
            }

            $data[$title] = $value;
        }
        return $data;
    }

    function generate()
    {
        global $userMeta;

        if(!$this->user) {
            return $userMeta->showError(__('User not found!', $userMeta->name));
        }
        if (!$this->form->isFound()) {
            return $userMeta->ShowError(sprintf(__('Form "%s" is not found!', $userMeta->name), $this->formName));
        }

        $fields = $this->getData();

        $html = '<div class="um_public_profile_display">';
        if($this->style == 'table') {
            $html .= '<table>';
            foreach ($fields as $title => $value) {
                $html .= '<tr><td>' . $title . '</td><td>' . $value .'</td></tr>' ;
            }
            $html .= '</table>';
        } elseif ($this->style == 'line') {
            foreach ($fields as $title => $value) {
                $html .= '<strong>' . $title . '</strong>';
                $html .= '<hr>'. $value .'<br>';
            }
        } else {
            foreach ($fields as $title => $value) {
                $html .= '<strong>' . $title . ' : ' . '</strong>' . $value;
                $html .= '<br>';
            }
        }
        $html .= '</div>';

        return $html;
    }
}