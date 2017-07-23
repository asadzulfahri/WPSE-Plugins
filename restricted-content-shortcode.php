<?php
/*
Plugin Name: Restricted Content Shortcode
Plugin URI: http://wordpress.stackexchange.com/q/57819/6035
Description: Adds a shortcode that hides content from non-logged in users
Author: Christopher Davis
Author URI: http://christopherdavis.me
License: GPL2

    Copyright 2012 Christopher Davis

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

add_action('init', 'wpse57819_add_shortcode');
/**
 * Adds the shortcode
 *
 * @uses add_shortcode
 * @return null
 */
function wpse57819_add_shortcode()
{
    add_shortcode('restricted', 'wpse57819_shortcode_cb');
}


/**
 * Callback function for the shortcode.  Checks if a user is logged in.  If they
 * are, display the content.  If not, show them a link to the login form.
 *
 * @return string
 */
function wpse57819_shortcode_cb($args, $content=null)
{
    // if the user is logged in just show them the content.  You could check
    // rolls and capabilities here if you wanted as well
    if(is_user_logged_in())
        return '<button onclick="restrictedFunction();">TOGGLE RESTRICTED CONTENT</button><div style="height:auto;background:#DFDFDF;" class="restricted-content">'.$content.'</div><script type="text/javascript" language="javascript">function restrictedFunction() { var elems = document.getElementsByClassName("restricted-content"); for(var i = 0; i != elems.length; ++i) { if (elems[i].style.display === "none") { elems[i].style.display = "block"; } else { elems[i].style.display = "none"; } } }</script>';


    // If we're here, they aren't logged in, show them a message
    $defaults = array(
        // message show to non-logged in users
        'msg'    => __('This section contains restricted content. Please contact the Administrator for more info.', 'wpse57819')
    );
    $args = wp_parse_args($args, $defaults);

    $msg = sprintf(
        '<!-- %s -->',
        esc_html($args['msg'])
    );

    return $msg;
}
