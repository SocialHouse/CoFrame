<?php

/**
 * Class Name: wp_bootstrap_navwalker
 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
 * Description: A custom WordPress nav walker class to implement the Twitter Bootstrap 2.3.2 navigation style in a custom theme using the WordPress built in menu manager.
 * Version: 2.0.2
 * Author: Edward McIntyre - @twittem
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class wp_bootstrap_navwalker extends Walker_Nav_Menu {
	private $curItem;
	private $megaMenu = 0;
    
    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
		$thisItem = $this->curItem;
		$thisDescr = $thisItem->post_content;
		$thisXfn = $thisItem->xfn;
        $indent = str_repeat("\t", $depth);
		if($depth == 0) {
			$output .= "\n$indent<ul role=\"menu\" class=\"dropdown-menu\">\n";
		}
		else {
			$output .= "\n$indent<ul role=\"menu\">\n";
		}
		if($thisXfn == 'megamenu') {
			$this->megaMenu = 1;
			$output .= "\n<li>\n<div class=\"mega-content container\">";
			if($thisDescr) {
				$output .= "\n<div class=\"col-md-6 mega-text\">";
				$output .= "\n<p>" . $thisDescr . "</p>";
				$output .= "</div>";
				$output .= "\n<div class=\"col-md-6\">\n<ul class=\"mega-nav clearfix\">";
			}
			else {
				$output .= "\n<div class=\"col-md-12\">\n<ul class=\"mega-nav clearfix\">";
			}
		}
    }

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		if($this->megaMenu == 1 && $depth ==0) {
			$output .= "</ul>\n</div>\n</div>\n</li>";
			$this->megaMenu = 0;
		}
		$output .= "$indent</ul>\n";
	}
    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param int $current_page Menu item ID.
     * @param object $args
     */

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$this->curItem = $item;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        /**
         * Dividers, Headers or Disabled
         * =============================
         * Determine whether the item is a Divider, Header, Disabled or regular
         * menu item. To prevent errors we use the strcasecmp() function to so a
         * comparison that is not case sensitive. The strcasecmp() function returns
         * a 0 if the strings are equal.
         */

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
            
		//Start Modification
		if($args->has_children) {
			if($depth>0){
				$class_names .= ' dropdown sub-menu'; 
			} else {
				$class_names .= ' dropdown'; 
			}
		}
		//End modification

		if(in_array('current-menu-item', $classes)) { $class_names .= ' active'; }

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$atts = array();
		$atts['title']  = ! empty( $item->title )   ? $item->title  : '';
		$atts['target'] = ! empty( $item->target )  ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn )     ? $item->xfn    : '';
		$atts['href']   = ! empty( $item->url )     ? $item->url    : '';
            
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$attributes .= ' class="nav-link"';
			
        if (strcasecmp($item->xfn, 'divider') == 0 && $depth === 1) {
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' nav-item divider' . '"' : '';
            $output .= $indent . '<li' . $id . $class_names .' role="presentation">';
        } else if (strcasecmp($item->xfn, 'megamenu') == 0 && $depth === 0) {
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' nav-item mega-menu' . '"' : '';
            $output .= $indent . '<li' . $id . $class_names .'><a'. $attributes .'>' . esc_attr( $item->title ) . '</a>';
        } else if (strcasecmp($item->xfn, 'dropdown-header') == 0 && $depth === 1) {
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' nav-item dropdown-header' . '"' : '';
            $output .= $indent . '<li' . $id . $class_names .' role="presentation">' . esc_attr( $item->title );
        } else if (strcasecmp($item->xfn, 'disabled') == 0) {
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' nav-item disabled' . '"' : '';
            $output .= $indent . '<li' . $id . $class_names .' role="presentation"><a href="#">' . esc_attr( $item->title ) . '</a>';
        } else {
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' nav-item' . '"' : '';
            $output .= $indent . '<li' . $id . $class_names .'>';


            $item_output = $args->before;

            /*
             * Glyphicons
             * ===========
             * Since the the menu item is NOT a Divider or Header we check the see
             * if there is a value in the attr_title property. If the attr_title
             * property is NOT null we apply it as the class name for the glyphicon.
             */

            if(! empty( $item->attr_title )){
                $item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>';
            } else {
                $item_output .= '<a'. $attributes .'>';
            }

            $caret = ($depth === 0) ? 'down' : 'right';
            
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }

    /**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max
     * depth and no ignore elements under that depth. 
     *
     * This method shouldn't be called directly, use the walk() method instead.
     *
     * @see Walker::start_el()
     * @since 2.5.0
     *
     * @param object $element Data object
     * @param array $children_elements List of elements to continue traversing.
     * @param int $max_depth Max depth to traverse.
     * @param int $depth Depth of current element.
     * @param array $args
     * @param string $output Passed by reference. Used to append additional content.
     * @return null Null on failure with no changes to parameters.
     */

    function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( !$element ) {
            return;
        }

        $id_field = $this->db_fields['id'];

        //display this element
        if ( is_object( $args[0] ) ) {
           $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}
?>