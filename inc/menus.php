<?php
/**
 * Registers nav menus
 */
function gb_register_nav_menus() {

   register_nav_menus( array(
      'main_menu' => __( 'Main menu', 'glasbestellen' ),
      'footer_menu_1' => __( 'Footer menu 1', 'glasbestellen' ),
      'footer_menu_2' => __( 'Footer menu 2', 'glasbestellen' ),
      'footer_menu_3' => __( 'Footer menu 3', 'glasbestellen' ),
      'footer_menu_4' => __( 'Footer menu 4', 'glasbestellen' ),
      'footer_menu_5' => __( 'Footer menu 5', 'glasbestellen' )
   ));

}
add_action( 'after_setup_theme', 'gb_register_nav_menus' );

/**
 * Get nav menu items by location
 *
 * @param $location The menu location id
 */
function get_nav_menu_items_by_location( $location, $args = [] ) {

    // Get all locations
    $locations = get_nav_menu_locations();

    // Get object id by location
    $object = wp_get_nav_menu_object( $locations[$location] );

    // Get menu items by menu name
    $menu_items = wp_get_nav_menu_items( $object->name, $args );

    // Return menu post objects
    return $menu_items;
}

/**
 * Builds a tree structured array from the main menu
 */
function gb_get_main_menu() {

   $menu_tree = [];

   if ( $items = get_nav_menu_items_by_location( 'main_menu' ) ) {

      $relationships = wp_list_pluck( $items, 'menu_item_parent', 'ID' );

      foreach ( $items as $item ) {

         $id        = $item->ID;
         $title     = $item->title;
         $url       = $item->url;
         $parent    = $item->menu_item_parent;
         $object_id = $item->object_id;

         $tree_item = [
            'id' => $id,
            'title' => $title,
            'url' => $url,
            'object_id' => $object_id
         ];

         if ( $parent == 0 ) {
            $menu_tree[$id] = $tree_item;
         } else {
            if ( $relationships[$parent] == 0 ) {
               $menu_tree[$parent]['children'][$id] = $tree_item;
            } else {
               $parents_parent = $relationships[$parent];
               $menu_tree[$parents_parent]['children'][$parent]['children'][$id] = $tree_item;
            }
         }

      }

   }
   return $menu_tree;
}

/**
 * Renders the main menu
 */
function gb_render_main_nav() {

   $html = '';

   if ( $menu_items = gb_get_main_menu() ) {

      $html .= '<ul class="main-nav__items js-nav-items">';

      foreach ( $menu_items as $menu_item ) {

         $class = 'main-nav__item';
         if ( ! empty( $menu_item['children'] ) ) {
            $class .= '  main-nav__item--parent js-nav-item-parent';
         }
         if ( $_SERVER['REQUEST_URI'] == parse_url( $menu_item['url'], PHP_URL_PATH ) ) {
            $class .= ' main-nav__item--current';
         }

         $html .= '<li class="' . $class . '">';

            $html .= '<a href="' . $menu_item['url'] . '" class="main-nav__link">' . $menu_item['title'] . '</a>';

            if ( ! empty( $menu_item['children'] ) ) {

               $html .= '<div class="main-nav__sub">';

                  $html .= '<ul class="main-nav__sub-items">';

                  foreach ( $menu_item['children'] as $submenu_item ) {

                     $html .= '<li class="main-nav__sub-item">';
                        $html .= '<a href="' . $submenu_item['url'] . '" class="main-nav__sub-link js-nav-subitem-link">' . $submenu_item['title'] . '</a>';
                     $html .= '</li>';
                  }

                  $html .= '</ul>';

               $html .= '</div>';
            }
         $html .= '</li>';
      }
      $html .= '</ul>';
   }

   echo $html;
}
