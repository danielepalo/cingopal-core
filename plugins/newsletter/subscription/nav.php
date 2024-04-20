<?php
?>
<ul class="tnp-nav">
    <!--<li class="tnp-nav-title">Subscription</li>-->
    <!--<li class="<?php echo $_GET['page'] === 'newsletter_subscription_index'?'active':''?>"><a href="?page=newsletter_subscription_index">Overview</a></li>-->
    <li class="<?php echo $_GET['page'] === 'newsletter_subscription_form'?'active':''?>"><a href="?page=newsletter_subscription_form">Form</a></li>
    <!--<li class="<?php echo $_GET['page'] === 'newsletter_subscription_sources'?'active':''?>"><a href="?page=newsletter_subscription_sources">Forms</a></li>-->
    <li class="<?php echo $_GET['page'] === 'newsletter_subscription_options'?'active':''?>"><a href="?page=newsletter_subscription_options">Settings and messages</a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_subscription_welcome'?'active':''?>"><a href="?page=newsletter_subscription_welcome">Welcome email</a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_subscription_antispam'?'active':''?>"><a href="?page=newsletter_subscription_antispam">Antispam</a></li>
    <?php if (NEWSLETTER_DEBUG) { ?>
    <li class="<?php echo $_GET['page'] === 'newsletter_subscription_debug'?'active':''?>"><a href="?page=newsletter_subscription_debug">Debug</a></li>
    <?php } ?>

</ul>
