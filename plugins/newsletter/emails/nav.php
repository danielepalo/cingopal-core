<?php
?>
<ul class="tnp-nav">
    <!--<li class="tnp-nav-title">Subscription</li>-->
    <li class="<?php echo $_GET['page'] === 'newsletter_emails_index'?'active':''?>"><a href="?page=newsletter_emails_index"><?php esc_html_e('Newsletters', 'newsletter')?></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_emails_presets'?'active':''?>"><a href="?page=newsletter_emails_presets"><?php esc_html_e('Templates', 'newsletter')?></a></li>
</ul>
