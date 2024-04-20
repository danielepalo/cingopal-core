<?php

defined('ABSPATH') || exit;

class NewsletterProfileAdmin extends NewsletterModuleAdmin {

    static $instance;

    /**
     * @return NewsletterProfileAdmin
     */
    static function instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct() {
        parent::__construct('profile');
    }
   
    function admin_menu() {
        $this->add_admin_page('index', __('Profile', 'newsletter'));
    }


}

