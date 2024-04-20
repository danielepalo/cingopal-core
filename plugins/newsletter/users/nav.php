<?php
?>
<ul class="tnp-nav">
    <li class="<?php echo $_GET['page'] === 'newsletter_users_index'?'active':''?>"><a href="?page=newsletter_users_index"><?php _e('Manage', 'newsletter')?></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_profile_index'?'active':''?>"><a href="?page=newsletter_profile_index"><?php _e('Profile page', 'newsletter')?></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_unsubscription_index'?'active':''?>"><a href="?page=newsletter_unsubscription_index"><?php _e('Unsubscribe', 'newsletter')?></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_users_statistics'?'active':''?>"><a href="?page=newsletter_users_statistics"><?php _e('Statistics', 'newsletter')?></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_users_massive'?'active':''?>"><a href="?page=newsletter_users_massive"><?php _e('Maintenance', 'newsletter')?></a></li>
</ul>
