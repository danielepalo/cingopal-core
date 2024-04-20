<?php
/* @var $this NewsletterUsersAdmin */
/* @var $controls NewsletterControls */

defined('ABSPATH') || exit;

$id = (int) $_GET['id'];
$user = $this->get_user($id);

if (!$user) {
    echo 'Subscriber not found.';
    return;
}

if ($controls->is_action('save')) {

    $email = $this->normalize_email($controls->data['email']);
    if (empty($email)) {
        $controls->errors = __('Wrong email address', 'newsletter');
    } else {
        $controls->data['email'] = $email;
    }


    if (empty($controls->errors)) {
        $u = $this->get_user($controls->data['email']);
        if ($u && $u->id != $id) {
            $controls->errors = __('The email address is already in use', 'newsletter');
        }
    }

    if (empty($controls->errors)) {
        // For unselected preferences, force the zero value
        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            if (!isset($controls->data['list_' . $i])) {
                $controls->data['list_' . $i] = 0;
            }
        }

        if (empty($controls->data['token'])) {
            $controls->data['token'] = $this->get_token();
        }

        $controls->data['id'] = $id;
        $user = $this->save_user($controls->data);
        $this->add_user_log($user, 'edit');
        if ($user === false) {
            $controls->errors = __('Error. Check the log files.', 'newsletter');
        } else {
            $controls->add_message_saved();
            $controls->data = (array) $user;
        }
    }
}

if ($controls->is_action('delete')) {
    $this->delete_user($id);
    $controls->js_redirect($this->get_admin_page_url('index'));
    return;
}

if (!$controls->is_action()) {
    $controls->data = (array) $user;
}

$options_profile = NewsletterSubscription::instance()->get_options('customfields');

function percent($value, $total) {
    if ($total == 0) {
        return '-';
    }
    return sprintf("%.2f", $value / $total * 100) . '%';
}

function percentValue($value, $total) {
    if ($total == 0) {
        return 0;
    }
    return round($value / $total * 100);
}

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart', 'geomap']});
</script>

<div class="wrap tnp-users tnp-users-edit" id="tnp-wrap">

    <?php include NEWSLETTER_ADMIN_HEADER ?>

    <div id="tnp-heading">
        <?php $controls->title_help('/subscribers-and-management/') ?>
        <h2><?php echo esc_html($user->email) ?></h2>
        <?php include __DIR__ . '/edit-nav.php' ?>
    </div>

    <div id="tnp-body">
        
        <?php $controls->show(); ?>

        <form method="post" action="">

            <?php $controls->init(); ?>

            <div id="tabs">

                <ul>

                    <li><a href="#tabs-newsletters"><?php _e('Newsletters', 'newsletter') ?></a></li>

                </ul>

               
                <div id="tabs-newsletters" class="tnp-tab">
                    <?php if (!has_action('newsletter_user_newsletters_tab') && !has_action('newsletter_users_edit_newsletters')) { ?>
                        <p>
                            This panel requires the <a href="https://www.thenewsletterplugin.com/plugins/newsletter/reports-module" target="_blank">Reports Addon</a>.
                        </p>
                        <?php
                    } else {
                        do_action('newsletter_user_newsletters_tab', $id);
                        do_action('newsletter_users_edit_newsletters', $id);
                    }
                    ?>
                </div>

            </div>


        </form>
    </div>

    <?php include NEWSLETTER_ADMIN_FOOTER ?>

</div>
