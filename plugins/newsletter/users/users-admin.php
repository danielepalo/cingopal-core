<?php

defined('ABSPATH') || exit;

class NewsletterUsersAdmin extends NewsletterModuleAdmin {

    static $instance;

    /**
     * @return NewsletterUnsubscriptionAdmin
     */
    static function instance() {
        if (self::$instance == null) {
            self::$instance = new NewsletterUsersAdmin();
        }
        return self::$instance;
    }

    function __construct() {
        parent::__construct('users', '1.0.7');
        add_action('wp_ajax_newsletter_users_export', [$this, 'hook_wp_ajax_newsletter_users_export']);
    }

    function admin_menu() {
        //$this->add_menu_page('index', __('Subscribers', 'newsletter'));
        $this->add_admin_page('new', __('New subscriber', 'newsletter'));
        $this->add_admin_page('edit', __('Subscriber Edit', 'newsletter'));
        $this->add_admin_page('logs', __('Logs', 'newsletter'));
        $this->add_admin_page('newsletters', __('Newsletters', 'newsletter'));
        $this->add_admin_page('massive', __('Subscribers Maintenance', 'newsletter'));
        $this->add_admin_page('export', __('Export', 'newsletter'));
        $this->add_admin_page('import', __('Import', 'newsletter'));
        $this->add_admin_page('statistics', __('Statistics', 'newsletter'));
    }

    function export($options = null) {
        global $wpdb;

        @setlocale(LC_CTYPE, 'en_US.UTF-8');
        header('Content-Type: application/octet-stream;charset=UTF-8');
        header('Content-Disposition: attachment; filename="newsletter-subscribers.csv"');

        // BOM
        echo "\xEF\xBB\xBF";

        $sep = ';';
        if ($options) {
            $sep = $options['separator'];
        }
        if ($sep == 'tab') {
            $sep = "\t";
        }

        // CSV header
        echo '"Email"' . $sep . '"Name"' . $sep . '"Surname"' . $sep . '"Gender"' . $sep . '"Status"' . $sep . '"Date"' . $sep . '"Token"' . $sep;

        // In table profiles
        for ($i = 1; $i <= NEWSLETTER_PROFILE_MAX; $i++) {
            echo '"Profile ' . $i . '"' . $sep; // To adjust with field name
        }

        // Lists
        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            echo '"List ' . $i . '"' . $sep;
        }

        echo '"Feed by mail"' . $sep . '"Follow up"' . $sep;
        echo '"IP"' . $sep . '"Referrer"' . $sep . '"Country"' . $sep . '"Language"' . $sep;
        echo '"ID"' . $sep . '"WP User ID"' . $sep;
        echo '"Last Activity"' . $sep;


        echo "\n";

        $page = 0;
        while (true) {
            $query = "select * from " . NEWSLETTER_USERS_TABLE . "";
            $list = (int) $_POST['options']['list'];
            if (!empty($list)) {
                $query .= " where list_" . $list . "=1";
            }
            $recipients = $wpdb->get_results($query . " order by email limit " . $page * 500 . ",500");
            for ($i = 0; $i < count($recipients); $i++) {
                echo '"' . $recipients[$i]->email . '"' . $sep;
                echo '"' . $this->sanitize_csv($recipients[$i]->name) . '"' . $sep;
                echo '"' . $this->sanitize_csv($recipients[$i]->surname) . '"' . $sep;
                echo '"' . $recipients[$i]->sex . '"' . $sep;
                echo '"' . $recipients[$i]->status . '"' . $sep;
                echo '"' . $recipients[$i]->created . '"' . $sep;
                echo '"' . $recipients[$i]->token . '"' . $sep;

                for ($j = 1; $j <= NEWSLETTER_PROFILE_MAX; $j++) {
                    $column = 'profile_' . $j;
                    echo '"' . $this->sanitize_csv($recipients[$i]->$column) . '"' . $sep;
                }

                for ($j = 1; $j <= NEWSLETTER_LIST_MAX; $j++) {
                    $list = 'list_' . $j;
                    echo '"' . $recipients[$i]->$list . '"' . $sep;
                }

                echo '"' . $recipients[$i]->feed . '"' . $sep;
                echo '"' . $recipients[$i]->followup . '"' . $sep;
                echo '"' . $this->sanitize_csv($recipients[$i]->ip) . '"' . $sep;
                echo '"' . $this->sanitize_csv($recipients[$i]->referrer) . '"' . $sep;
                echo '"' . $this->sanitize_csv($recipients[$i]->country) . '"' . $sep;
                echo '"' . $this->sanitize_csv($recipients[$i]->language) . '"' . $sep;
                echo '"' . $recipients[$i]->id . '"' . $sep;
                echo '"' . $recipients[$i]->wp_user_id . '"' . $sep;
                echo '"' . date('Y-m-d H:i:s', $recipients[$i]->last_activity) . '"' . $sep;

                echo "\n";
                flush();
            }
            if (count($recipients) < 500) {
                break;
            }
            $page++;
        }
        die();
    }


    function sanitize_csv($text) {
        $text = str_replace(['"', "\n", "\r", ";"], ["'", " ", " ", " "], $text);

        // Excel... of course!
        $first = substr($text, 0, 1);
        if ($first === '=' || $first === '+' || $first === '-' || $first === '@') {
            $text = "'" . $text;
        }

        return $text;
    }

    function hook_wp_ajax_newsletter_users_export() {

        if ($this->is_allowed()) {
            require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
            $controls = new NewsletterControls();

            if ($controls->is_action('export')) {
                $this->export($controls->data);
            }
        } else {
            die('Not allowed.');
        }
    }

}

class TNP_Subscribers_Stats {

    var $total;
    var $confirmed;
    var $unconfirmed;
    var $bounced;

}
