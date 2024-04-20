<?php

defined('ABSPATH') || exit;

class NewsletterProfile extends NewsletterModule {

    static $instance;

    /**
     * @return NewsletterProfile
     */
    static function instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct() {
        parent::__construct('profile');
        add_shortcode('newsletter_profile', [$this, 'shortcode_newsletter_profile']);
        add_filter('newsletter_replace', [$this, 'hook_newsletter_replace'], 10, 4);
        add_filter('newsletter_page_text', [$this, 'hook_newsletter_page_text'], 10, 3);
        add_action('newsletter_action', [$this, 'hook_newsletter_action'], 12, 3);
        add_action('newsletter_action_dummy', [$this, 'hook_newsletter_action_dummy'], 12, 3);
    }

    function message_url($user = null, $email = null, $alert = '') {
        if ($user) {
            $this->switch_language($user->language);
        }
        $url = trim($this->get_option('url')); // Compatibility with old parameter
        if (empty($url)) {
            $page_id = $this->get_option('page_id');
            if (!empty($page_id)) {
                if ($page_id === 'url') {
                    $url = trim($this->get_option('page_url'));
                } else {
                    $url = get_permalink((int) $page_id);
                }
            }
        }
        $url = parent::build_message_url($url, 'profile', $user, $email, $alert);
        if ($user) {
            $this->restore_language();
        }
        return $url;
    }

    function hook_newsletter_action_dummy($action, $user, $email) {
        if (!in_array($action, ['p', 'profile', 'pe', 'profile-save', 'profile_export', 'ps'])) {
            return;
        }

        switch ($action) {
            case 'profile':
            case 'p':
                $profile_url = $this->message_url($user, $email);
                $this->redirect($profile_url);
                break;

            case 'profile-save':
            case 'ps':
                $this->redirect($this->message_url($user, $email, $this->get_text('saved')));
                break;
        }
    }

    function hook_newsletter_action($action, $user, $email) {

        if (!in_array($action, ['p', 'profile', 'pe', 'profile-save', 'profile_export', 'ps'])) {
            return;
        }

        if (!$user || $user->status != TNP_User::STATUS_CONFIRMED) {
            $this->dienow(__('Subscriber not found or not confirmed or started from a test newsletter.', 'newsletter'), 'From a test newsletter or subscriber key not valid or subscriber not confirmed', 404);
        }

        switch ($action) {
            case 'profile':
            case 'p':
            case 'pe':

                $profile_url = $this->message_url($user, $email);
                $profile_url = apply_filters('newsletter_profile_url', $profile_url, $user); // Compatibility

                $this->redirect($profile_url);

                break;

            case 'profile-save':
            case 'ps':
                $res = $this->save_profile($user);
                if (is_wp_error($res)) {
                    $this->redirect($this->message_url($user, $email, $res->get_error_message()));
                }

                $this->redirect($this->message_url($user, $email));
                break;

            case 'profile_export':
                header('Content-Type: application/json;charset=UTF-8');
                echo $this->to_json($user);
                die();
        }
    }

    /**
     *
     * @param stdClass $user
     */
    function get_profile_export_url($user) {
        return $this->build_action_url('profile_export', $user);
    }

    /**
     * URL to the subscriber profile edit action. This URL MUST NEVER be changed by
     * 3rd party plugins. Plugins can change the final URL after the action has been executed using the
     * <code>newsletter_profile_url</code> filter.
     *
     * @param stdClass $user
     */
    function get_profile_url($user, $email = null) {
        return $this->build_action_url('profile', $user, $email);
    }

    function hook_newsletter_replace($text, $user, $email, $html = true) {
        if (!$user) {
            $text = $this->replace_url($text, 'PROFILE_URL', $this->build_action_url('nul'));
            return $text;
        }

        // Profile edit page URL and link
        $url = $this->get_profile_url($user, $email);
        $text = $this->replace_url($text, 'profile_url', $url);
        // Profile export URL and link
        $url = $this->get_profile_export_url($user);
        $text = $this->replace_url($text, 'profile_export_url', $url);

        if (strpos($text, '{profile_form}') !== false) {
            $text = str_replace('{profile_form}', $this->get_profile_form($user), $text);
        }
        return $text;
    }

    /**
     *
     * @param type $text
     * @param type $key
     * @param TNP_User $user
     * @return string
     */
    function hook_newsletter_page_text($text, $key, $user) {
        if ($key !== 'profile') {
            return $text;
        }

        if (!$this->is_current_user_dummy()) {
            if (!$user || $user->status === TNP_User::STATUS_UNSUBSCRIBED) {
                return __('Subscriber not found.', 'newsletter');
            }
        }

        $text = $this->get_text('text');
        $text = str_replace('{profile_form}', '[newsletter_profile]', $text);

        // Admin notice
        $admin_notice = '';
        if ($user && $user->id === 0 && current_user_can('administrator')) {
            $admin_notice = '<p style="background-color: #eee; color: #000; padding: 1rem; margin: 1rem 0"><strong>Visible only to administrators</strong>. Preview of the content with a dummy subscriber. <a href="' . admin_url('admin.php?page=newsletter_profile_index') . '" target="_blank">Edit this content</a>.</p>';
        }
        return $admin_notice . $text;
    }

    function shortcode_newsletter_profile($attrs, $content = '') {
        if ($this->is_current_user_dummy()) {
            $user = $this->get_dummy_user();
        } else {
            $user = $this->check_user();
        }

        if (empty($user)) {
            if (empty($content)) {
                return __('Subscriber not found.', 'newsletter');
            } else {
                return $content;
            }
        }

        return $this->get_profile_form($user);
    }

    /**
     * Build the profile editing form for the specified subscriber.
     *
     * @param TNP_User $user
     * @return string
     */
    function get_profile_form($user) {

        $this->switch_language($user->language);

        $options = $this->get_options(); // Per language

        $subscription = NewsletterSubscription::instance();

        $buffer = '';

        $buffer .= '<div class="tnp tnp-form tnp-profile">';
        $buffer .= '<form action="' . $this->build_action_url('ps') . '" method="post">';
        $buffer .= '<input type="hidden" name="nk" value="' . esc_attr($user->id . '-' . $user->token) . '">';

        if (!empty($options['email'])) {
            $buffer .= '<div class="tnp-field tnp-field-email">';
            $buffer .= '<label>' . esc_html($subscription->get_form_text('email')) . '</label>';
            $buffer .= '<input class="tnp-email" type="text" name="ne" required value="' . esc_attr($user->email) . '">';
            $buffer .= "</div>\n";
        }


        if (!empty($options['name'])) {
            $buffer .= '<div class="tnp-field tnp-field-firstname">';
            $buffer .= '<label>' . esc_html($subscription->get_form_text('name')) . '</label>';
            $buffer .= '<input class="tnp-firstname" type="text" name="nn" value="' . esc_attr($user->name) . '"' . (!empty($options['name_required']) ? ' required' : '') . '>';
            $buffer .= "</div>\n";
        }

        if (!empty($options['surname'])) {
            $buffer .= '<div class="tnp-field tnp-field-lastname">';
            $buffer .= '<label>' . esc_html($subscription->get_form_text('surname')) . '</label>';
            $buffer .= '<input class="tnp-lastname" type="text" name="ns" value="' . esc_attr($user->surname) . '"' . (!empty($options['surname_required']) ? ' required' : '') . '>';
            $buffer .= "</div>\n";
        }

        if (!empty($options['sex'])) {
            if (empty($user->sex))
                $user->sex = 'n';
            $buffer .= '<div class="tnp-field tnp-field-gender">';
            $buffer .= '<label>' . esc_html($subscription->get_form_text('sex')) . '</label>';
            $buffer .= '<select name="nx" class="tnp-gender"';

            $buffer .= '>';

            $buffer .= '<option value="n"' . ($user->sex == 'n' ? ' selected' : '') . '>' . esc_html($subscription->get_form_text('sex_none')) . '</option>';
            $buffer .= '<option value="f"' . ($user->sex == 'f' ? ' selected' : '') . '>' . esc_html($subscription->get_form_text('sex_female')) . '</option>';
            $buffer .= '<option value="m"' . ($user->sex == 'm' ? ' selected' : '') . '>' . esc_html($subscription->get_form_text('sex_male')) . '</option>';
            $buffer .= '</select>';
            $buffer .= "</div>\n";
        }

        if (!empty($options['language'])) {
            if ($this->is_multilanguage()) {

                $languages = $this->get_languages();

                $buffer .= '<div class="tnp-field tnp-field-language">';
                $buffer .= '<label>' . esc_html__('Language', 'newsletter') . '</label>';
                $buffer .= '<select name="nlng" class="tnp-language">';

                $buffer .= '<option value="" disabled ' . ( empty($user->language) ? ' selected' : '' ) . '>' . __('Select language', 'newsletter') . '</option>';
                foreach ($languages as $key => $l) {
                    $buffer .= '<option value="' . esc_attr($key) . '"' . ( $user->language == $key ? ' selected' : '' ) . '>' . esc_html($l) . '</option>';
                }

                $buffer .= '</select>';
                $buffer .= "</div>\n";
            }
        }

        // Custom fields
        if (!empty($options['profiles'])) {
            $profiles = $this->get_customfields_public();
            foreach ($profiles as $profile) {
                if (!in_array($profile->id, $options['profiles'])) {
                    continue;
                }

                $i = $profile->id; // I'm lazy

                $buffer .= '<div class="tnp-field tnp-field-profile">';
                $buffer .= '<label>' . esc_html($profile->name) . '</label>';

                $field = 'profile_' . $i;

                if ($profile->is_text()) {
                    $buffer .= '<input class="tnp-profile tnp-profile-' . esc_attr($i) . '" type="text" name="np' . esc_attr($i) . '" value="' . esc_attr($user->$field) . '"' .
                            ($profile->is_required() ? ' required' : '') . '>';
                }

                if ($profile->is_select()) {
                    $buffer .= '<select class="tnp-profile tnp-profile-' . esc_attr($i) . '" name="np' . esc_attr($i) . '"' . ($profile->is_required() ? ' required' : '') . '>';
                    foreach ($profile->options as $option) {
                        $buffer .= '<option';
                        if ($option == $user->$field) {
                            $buffer .= ' selected';
                        }
                        $buffer .= '>' . esc_html($option) . '</option>';
                    }
                    $buffer .= '</select>';
                }

                $buffer .= "</div>\n";
            }
        }

        // Lists
        if (!empty($options['lists'])) {
            $lists = $this->get_lists_public();
            $tmp = '';
            foreach ($lists as $list) {
                if (!in_array($list->id, $options['lists']) || $list->is_private()) {
                    continue;
                }
                $tmp .= '<div class="tnp-field tnp-field-list">';
                $tmp .= '<label><input class="tnp-list tnp-list-' . $list->id . '" type="checkbox" name="nl[]" value="' . $list->id . '"';
                $field = 'list_' . $list->id;
                // isset() for dummy subscribers
                if (isset($user->$field) && $user->$field == 1) {
                    $tmp .= ' checked';
                }
                $tmp .= '><span class="tnp-list-label">' . esc_html($list->name) . '</span></label>';
                $tmp .= "</div>\n";
            }

            if (!empty($tmp)) {
                $buffer .= '<div class="tnp-lists">' . "\n" . $tmp . "\n" . '</div>';
            }
        }

        // Privacy
        $privacy_url = $subscription->get_privacy_url();
        if (!empty($this->get_text('privacy_label')) && !empty($privacy_url)) {
            $buffer .= '<div class="tnp-field tnp-field-privacy">';
            if ($privacy_url) {
                $buffer .= '<a href="' . $privacy_url . '" target="_blank">';
            }

            $buffer .= $this->get_text('privacy_label');

            if ($privacy_url) {
                $buffer .= '</a>';
            }
            $buffer .= "</div>\n";
        }

        $buffer .= '<div class="tnp-field tnp-field-button">';
        $buffer .= '<input class="tnp-submit" type="submit" value="' . esc_attr($this->get_text('save_label')) . '">';
        $buffer .= "</div>\n";

        $buffer .= "</form>\n</div>\n";

        $this->restore_language();

        return $buffer;
    }

    /**
     * Saves the subscriber data extracting them from the $_REQUEST and for the
     * subscriber identified by the <code>$user</code> object.
     *
     * @return string|WP_Error If not an error the string represent the message to show
     */
    function save_profile($user) {

        $options = $this->get_options();

        $subscription_module = NewsletterSubscription::instance();

        // Conatains the cleaned up user data to be saved
        $data = ['id' => $user->id];

        require_once NEWSLETTER_INCLUDES_DIR . '/antispam.php';

        $antispam = NewsletterAntispam::instance();

        $email_changed = false;

        if ($options['email']) {
            $email = $this->normalize_email(stripslashes($_REQUEST['ne']));

            if ($antispam->is_address_blacklisted($email)) {
                return new WP_Error('spam', $this->get_text('error'));
            }

            if (!$email) {
                return new WP_Error('email', $this->get_text('error'));
            }

            $email_changed = ($email != $user->email);

            // If the email has been changed, check if it is available
            if ($email_changed) {
                $tmp = $this->get_user($email);
                if ($tmp != null && $tmp->id != $user->id) {
                    return new WP_Error('inuse', $this->get_text('error'));
                }
            }

            if ($email_changed && $subscription_module->is_double_optin()) {
                set_transient('newsletter_user_' . $user->id . '_email', $email, DAY_IN_SECONDS);
            } else {
                $data['email'] = $email;
            }
        }

        if (isset($_REQUEST['nn'])) {
            $data['name'] = $this->normalize_name(stripslashes($_REQUEST['nn']));
            if ($antispam->is_spam_text($data['name'])) {
                return new WP_Error('spam', $this->get_text('error'));
            }
        }
        if (isset($_REQUEST['ns'])) {
            $data['surname'] = $this->normalize_name(stripslashes($_REQUEST['ns']));
            if ($antispam->is_spam_text($data['surname'])) {
                return new WP_Error('spam', $this->get_text('error'));
            }
        }
        if (isset($_REQUEST['nx'])) {
            $data['sex'] = substr($_REQUEST['nx'], 0, 1);
            // Wrong data injection check
            if ($data['sex'] != 'm' && $data['sex'] != 'f' && $data['sex'] != 'n') {
                die('Wrong sex field');
            }
        }
        if (isset($_REQUEST['nlng'])) {
            $languages = $this->get_languages();
            if (isset($languages[$_REQUEST['nlng']])) {
                $data['language'] = trim($_REQUEST['nlng']);
            }
        }

        // Lists. If not list is present or there is no list to choose or all are unchecked.
        $nl = [];
        if (isset($_REQUEST['nl']) && is_array($_REQUEST['nl'])) {
            $nl = $_REQUEST['nl'];
        }

        // Every possible list shown in the profile must be processed
        $ids = $this->get_main_option('lists');
        foreach ($ids as $id) {
            $list = $this->get_list($id);
            if (!$list || $list->is_private())
                continue;
            $field_name = 'list_' . $id;
            $data['list_' . $id] = in_array($id, $nl) ? 1 : 0;
        }

        // Profile
        $ids = $this->get_main_option('profiles');
        if ($ids) {
            foreach ($ids as $id) {
                $profile = $this->get_profile($id);
                if (!$profile || $profile->is_private())
                    continue;
                if (isset($_REQUEST['np' . $id])) {
                    $data['profile_' . $id] = wp_kses_post(stripslashes($_REQUEST['np' . $id]));
                }
            }
        }

        if ($user->status == TNP_User::STATUS_NOT_CONFIRMED) {
            $data['status'] = TNP_User::STATUS_CONFIRMED;
        }

        $user = $this->save_user($data);
        $this->add_user_log($user, 'profile');

        // Send the activation again only if we use double opt-in, otherwise it has no meaning
        if ($email_changed && $subscription_module->is_double_optin()) {
            $user->email = $email;
            $subscription_module->send_activation_email($user);
            return $this->get_text('email_changed');
        }

        return $this->get_text('saved');
    }

    // Patch to avoid conflicts with the "newsletter_profile" option of the subscription module
    // TODO: Fix it
    public function get_prefix($sub = '', $language = '') {
        if (empty($sub)) {
            $sub = 'main';
        }
        return parent::get_prefix($sub, $language);
    }

    function to_json($user) {
        global $wpdb;

        $fields = array('name', 'surname', 'sex', 'created', 'ip', 'email');
        $data = array(
            'email' => $user->email,
            'name' => $user->name,
            'last_name' => $user->surname,
            'gender' => $user->sex,
            'created' => $user->created,
            'ip' => $user->ip,
        );

        // Lists
        $lists = $this->get_lists_public();
        $data['lists'] = [];
        foreach ($lists as $list) {
            $field = 'list_' . $list->id;
            if ($user->$field == 1) {
                $data['lists'][] = $list->name;
            }
        }

        // Profile
        $profiles = $this->get_profiles_public();
        $data['profiles'] = [];
        foreach ($profiles as $profile) {
            $field = 'profile_' . $profile->id;
            $data['profiles'][] = array('name' => $profile->name, 'value' => $user->$field);
        }

        $extra = apply_filters('newsletter_profile_export_extra', []);

        $data = array_merge($extra, $data);

        return json_encode($data, JSON_PRETTY_PRINT);
    }
}

NewsletterProfile::instance();
