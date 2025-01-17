<?php
namespace UserMeta\Wpml2;

/**
 * Do translation jobs
 *
 * @author Khaled Hossain
 *        
 * @since 1.4
 */
class Translate
{

    /**
     * Translate ump settings
     *
     * @param array $settings            
     * @return array
     */
    public function translateSettings($settings)
    {
        $pages = [
            'general' => [
                'profile_page'
            ],
            'login' => [
                'login_page',
                'resetpass_page'
            ],
            'registration' => [
                'user_registration_page',
                'email_verification_page'
            ]
        ];
        foreach ($pages as $key => $group) {
            foreach ($group as $page) {
                if (! empty($settings[$key][$page]))
                    $settings[$key][$page] = $this->translatedPageID($settings[$key][$page]);
            }
        }
        $this->translateRedirectionSettings($settings['redirection']);
        
        return $settings;
    }

    /**
     * Translate redirection settings
     */
    private function translateRedirectionSettings(&$data)
    {
        $keys = [
            'login_page',
            'logout_page',
            'registration_page'
        ];
        foreach ($keys as $key) {
            if (isset($data[$key]) && is_array($data[$key])) {
                foreach ($data[$key] as $role => $pageID)
                    $data[$key][$role] = $this->translatedPageID($pageID);
            }
        }
        
        return $data;
    }

    /**
     * Translate page id
     * @required WPML-3.2+
     *
     * @param int $pageID            
     * @return int
     */
    private function translatedPageID($pageID)
    {
        return apply_filters('wpml_object_id', $pageID, 'post', true);
    }
}