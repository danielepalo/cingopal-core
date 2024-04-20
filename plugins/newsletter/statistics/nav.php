<?php
?>
<ul class="tnp-nav">
    <li class="<?php echo $_GET['page'] === 'newsletter_statistics_view'?'active':''?>"><a href="?page=newsletter_statistics_view&id=<?php echo $email->id?>"><?php _e('Overview', 'newsletter')?></a></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_statistics_view-urls'?'active':''?>"><a href="?page=newsletter_statistics_view-urls&id=<?php echo $email->id?>"><?php _e('Links', 'newsletter')?></a> <span class="tnp-pro-badge">Pro</span></li>
    <li class="<?php echo $_GET['page'] === 'newsletter_statistics_view-users'?'active':''?>"><a href="?page=newsletter_statistics_view-users&id=<?php echo $email->id?>"><?php _e('Subscribers', 'newsletter')?></a> <span class="tnp-pro-badge">Pro</span></li>
    <?php if (class_exists('NewsletterReports')) { ?>
    <li><a href="?page=newsletter_reports_view&id=<?php echo $email->id?>"><?php _e('Full', 'newsletter')?></a></li>
    <?php } ?>
<!--    <li class="<?php echo $_GET['page'] === 'newsletter_statistics_retarget'?'active':''?>"><a href="?page=newsletter_statistics_retarget&id=<?php echo $email->id?>"><?php _e('Retarget', 'newsletter')?></a></li>-->
</ul>
