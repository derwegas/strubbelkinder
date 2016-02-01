<div class="clear"></div>
<div class="updated notice" style="width: 95%;">
    <p>
        <?php echo str_replace("%s", $time, langWPADM::get('You use Dropbox backup and restore plugin successfully for more than %s. Please, leave a 5 star review for our development team, because it inspires us to develop this plugin for you.', false )) ; ?><br />
        <?php langWPADM::get('Thank you!')?>
        <br />
        <a href="https://wordpress.org/support/view/plugin-reviews/dropbox-backup?filter=5"  ><?php langWPADM::get('Leave review'); ?></a><br />
        <a href="<?php echo admin_url( 'admin-post.php?action=hide_notice&type=star' );?>"><?php langWPADM::get('I already left a review'); ?></a><br />
        <a href="<?php echo admin_url( 'admin-post.php?action=hide_notice&type=star&hide=' . $hide );?>"><?php langWPADM::get('Hide this message'); ?></a><br />
    </p>
</div>
