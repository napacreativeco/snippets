
<?php
/* Place this in the area you want the menu to appear */

wp_nav_menu(
    array(
    'menu'              => 'footer-menu',
    'theme_location'    => 'footer-menu',
    'menu_class'        => 'footer-menu'
    )
);
?>