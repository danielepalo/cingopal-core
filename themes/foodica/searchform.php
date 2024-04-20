<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>/">
    <input type="search" class="sb-search-input" placeholder="<?php esc_attr_e( 'Enter your keywords...', 'foodica' ); ?>"  name="s" id="s" />
    <input type="submit" id="searchsubmit" class="sb-search-submit" value="<?php esc_attr_e('Search', 'foodica') ?>" />
    <span class="sb-icon-search"></span>
</form>