<?php

namespace UserMeta\MailChimp;

$clearLogsUrl = admin_url('admin-ajax.php');
$clearLogsUrl = add_query_arg(array(
    'option' => 'user_meta_addon_mailchimp_logs',
    'redirect' => 'addons',
    'method_name' => 'clearOption',
    'action' => 'pf_ajax_request'
), $clearLogsUrl);
$clearLogsUrl = wp_nonce_url($clearLogsUrl, 'clear_option');

$logs = get_option('user_meta_addon_mailchimp_logs');
$html = '';
$html .= '<br>';
$html .= '<p>'. __('Recent Logs (up to 500 records):', 'user-meta') . '</p>';
$html .= '<a href="'. $clearLogsUrl . '" class="button">'. __('Clear Logs', 'user-meta') . '</a>';
$html .= '<hr>';

if(!empty($logs)) {
    $index = count($logs);
    while ($index) {
        $log = $logs[--$index];
        $action = empty($log['action']) ? '' : esc_html($log['action']);
        $outcome = empty($log['outcome']) ? '' : esc_html($log['outcome']);
        $time = empty($log['time']) ? '' : esc_html($log['time']);
        $email = empty($log['email']) ? '' : esc_html($log['email']);
        $list = empty($log['list']) ? '' : esc_html($log['list']);
        $error = empty($log['error']) ? '' : esc_html($log['error']);


        $html .= ($outcome == 'Failure') ? '<span style="color: red">' . $action . '|' . $outcome . '! ' . '</span>' : '<span style="color: green">' . $action . '|' . $outcome . '! ' . '</span>';
        $html .= 'Time: ' . $time . ', Email: ' . $email . ', List ID: ' . $list . ', Error: ' . $error;
        $html .= '<br>';
    }
}
echo $html;

