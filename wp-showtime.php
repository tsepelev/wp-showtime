<?php
/*
Plugin Name: WP Showtime
Plugin URI: http://tsepelev.ru/wp-showtime
Description: The plugin allows you to display on any page of your blog movie showtimes. There is the possibility showtimes for any city.
Version: 1.0
Author: Sergey Tsepelev
Author URI: http://tsepelev.ru
*/

/*  Copyright 2010  WP Showtime  (email: sergey@tsepelev.ru)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
add_action('plugins_loaded', 'wp_showtime_init');
function wp_showtime_init()
{
    load_plugin_textdomain('wp-showtime', false, dirname(plugin_basename(__FILE__)));
}

//add_action('admin_menu', 'tp_add_tools_menu');
add_action('admin_menu', 'wp_showtime_menu');

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wp_showtime_action_links');

function wp_showtime_action_links($links)
{
    $links[] = '<a href="' . esc_url(get_admin_url(null, 'options-general.php?page=wp-showtime')) . '">' . __('Settings') . '</a>';
    return $links;
}

function wp_showtime_menu()
{
    add_options_page('WP Showtime Options', 'WP Showtime', 'manage_options', 'wp-showtime', 'tp_manage_menu');
}

add_shortcode('showtime', 'show_showtime');

function tp_manage_menu()
{

    include('wp-showtime-opt.php');

}

function show_showtime()
{
        include('wp-showtime-func.php');
}
