<?php
?>
<ul class="tnp-nav">
    <!--<li class="tnp-nav-title">Subscription</li>-->
    <li class="<?php echo $_GET['page'] === 'newsletter_subscription_sources'?'active':''?>"><a href="?page=newsletter_subscription_sources">All forms</a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_subscription_shortcodes'?'active':''?>"><a href="?page=newsletter_subscription_shortcodes">Shortcodes &amp; Widgets</a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_subscription_forms'?'active':''?>"><a href="?page=newsletter_subscription_forms">HTML Forms</a></li>

</ul>
