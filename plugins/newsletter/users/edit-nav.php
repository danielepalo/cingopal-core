<?php
?>
<ul class="tnp-nav">
    <li><a href="?page=newsletter_users_index"><i class="fas fa-chevron-left"></i></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_users_edit'?'active':''?>"><a href="?page=newsletter_users_edit&id=<?php echo $user->id?>"><?php _e('Data', 'newsletter')?></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_users_logs'?'active':''?>"><a href="?page=newsletter_users_logs&id=<?php echo $user->id?>"><?php _e('Logs', 'newsletter')?></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_users_newsletters'?'active':''?>"><a href="?page=newsletter_users_newsletters&id=<?php echo $user->id?>"><?php _e('Newsletters', 'newsletter')?></a></li>
</ul>
