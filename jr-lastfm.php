<?php
/*
Plugin Name: JR_Last.FM
Plugin URI: http://www.jakeruston.co.uk/2009/11/wordpress-plugin-jr-lastfm/
Description: Displays your recent last.fm tracks as a widget.
Version: 1.1.2
Author: Jake Ruston
Author URI: http://www.jakeruston.co.uk
*/

/*  Copyright 2009 Jake Ruston - the.escapist22@gmail.com

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

// Hook for adding admin menus
add_action('admin_menu', 'jr_lastfm_add_pages');
add_action('wp_head','lastfm_delete_cache');
add_action('delete_lastfm_cache','delete_lastfm_cache');

// action function for above hook
function jr_lastfm_add_pages() {
    add_options_page('JR Last.FM', 'JR Last.FM', 'administrator', 'jr_lastfm', 'jr_lastfm_options_page');
}

// jr_lastfm_options_page() displays the page content for the Test Options submenu
function jr_lastfm_options_page() {

    // variables for the field and option names 
    $opt_name = 'mt_lastfm_account';
    $opt_name_2 = 'mt_lastfm_limit';
    $opt_name_5 = 'mt_lastfm_plugin_support';
    $opt_name_6 = 'mt_lastfm_title';
    $opt_name_9 = 'mt_lastfm_cache';
	$opt_name_10 = 'mt_lastfm_title2';
    $hidden_field_name = 'mt_lastfm_submit_hidden';
    $data_field_name = 'mt_lastfm_account';
    $data_field_name_2 = 'mt_lastfm_limit';
    $data_field_name_5 = 'mt_lastfm_plugin_support';
    $data_field_name_6 = 'mt_lastfm_title';
    $data_field_name_9 = 'mt_lastfm_cache';
	$data_field_name_10 = 'mt_lastfm_title2';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
    $opt_val_2 = get_option($opt_name_2);
    $opt_val_5 = get_option($opt_name_5);
    $opt_val_6 = get_option($opt_name_6);
    $opt_val_9 = get_option($opt_name_9);
	$opt_val_10 = get_option($opt_name_10);
    
if ($_POST['delcache']=="true") {
update_option("mt_lastfm_cachey", "");
update_option("mt_lastfm_cachey2", "");
}

if (!$_POST['feedback']=='') {
$my_email1="the.escapist22@gmail.com";
$plugin_name="JR Last.FM";
$blog_url_feedback=get_bloginfo('url');
$feedback_feedback=$_POST['feedback'];
$headers1 = "From: feedback@jakeruston.co.uk";
$emailsubject1="Plugin Feedback - ".$plugin_name;
$emailmessage1="Blog: $blog_url_feedback\n\nMessage: $feedback_feedback";
mail($my_email1,$emailsubject1,$emailmessage1,$headers1);
}

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];
        $opt_val_2 = $_POST[$data_field_name_2];
        $opt_val_5 = $_POST[$data_field_name_5];
        $opt_val_6 = $_POST[$data_field_name_6];
        $opt_val_9 = $_POST[$data_field_name_9];
		$opt_val_10 = $_POST[$data_field_name_10];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );
        update_option( $opt_name_2, $opt_val_2 );
        update_option( $opt_name_5, $opt_val_5 );
        update_option( $opt_name_6, $opt_val_6 ); 
        update_option( $opt_name_9, $opt_val_9 );
		update_option( $opt_name_10, $opt_val_10 );
		update_option("mt_lastfm_cachey", "");
		update_option("mt_lastfm_cachey2", "");

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'JR Last.FM Plugin Options', 'mt_trans_domain' ) . "</h2>";

    // options form
   
    $change3 = get_option("mt_lastfm_plugin_support");
    $change6 = get_option("mt_lastfm_cache");

if ($change3=="Yes" || $change3=="") {
$change3="checked";
$change31="";
} else {
$change3="";
$change31="checked";
}

    ?>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Widget Latest Tracks Title:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_6; ?>" value="<?php echo $opt_val_6; ?>" size="50">
</p><hr />

<p><?php _e("Widget Top Tracks Title:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_10; ?>" value="<?php echo $opt_val_10; ?>" size="50">
</p><hr />

<p><?php _e("Last.FM Username:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
</p><hr />

<p><?php _e("Number of Tracks to Show:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_2; ?>" value="<?php echo $opt_val_2; ?>" size="3">
</p><hr />

<p><?php _e("How long should the cache last for? Recommended 10 minutes.", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_9; ?>" value="<?php echo $opt_val_9; ?>" size="4"> Minutes
</p><hr />

<p><?php _e("Show Plugin Support?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="Yes" <?php echo $change3; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="No" <?php echo $change31; ?> id="Please do not disable plugin support - This is the only thing I get from creating this free plugin!" onClick="alert(id)">No
</p><hr />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p><hr />

</form>

<form action="" method="post"><input type="hidden" name="delcache" value="true" /><input type="submit" value="Delete Cache" /></form><br /><br />

<h3>Give Me Feedback!</h3>
<form name="form2" method="post" action="">
<p><?php _e("Comment:", 'mt_trans_domain' ); ?> 
<textarea name="feedback"></textarea>
</p>
<p class="submit">
<input type="submit" name="Send" value="<?php _e('Send', 'mt_trans_domain' ) ?>" />
</p><hr />
</form>
</div>
<?php
 
}

function lastfm_delete_cache() {
$optionlastfmcache = get_option("mt_lastfm_cache");

$optionlastfmcache=$optionlastfmcache*60;

$schedule=wp_next_scheduled("delete_lastfm_cache");

if ($schedule=="") {
wp_schedule_single_event(time()+$optionlastfmcache, 'delete_lastfm_cache'); 
}
}

function delete_lastfm_cache() {
update_option("mt_lastfm_cachey", "");
update_option("mt_lastfm_cachey2", "");
}

function show_lastfm_latest() {
  $widget_title = get_option("mt_lastfm_title"); 
  $widget_title2 = get_option("mt_lastfm_title2");
  $max_tracks = get_option("mt_lastfm_limit");  
  $optionlastfm = get_option("mt_lastfm_account");
  $supportplugin = get_option("mt_lastfm_plugin_support"); 
  $optionlastfmcache = get_option("mt_lastfm_cache");
if (!$optionlastfm=="") {

$widget_title=str_replace("%user%", $optionlastfm, $widget_title);

$doc = new DOMDocument();
 
if($doc->load('http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user='.$optionlastfm.'&limit='.$max_tracks.'&api_key=493bd628f307f4c4d268f24ab5239472')) {
 
  $i = 1;

$cachey = get_option("mt_lastfm_cachey");

if (!$cachey=="") {
if (!$optionlastfmcache=="0") {
echo $cachey;

lastfm_delete_cache();
}

} else {
$lastfmdisp="";

  $lastfmdisp .= '<div id="recent-posts-4" class="widget widget_recent_entries"><h3>'; 

  $lastfmdisp .= $widget_title.'</h3><ul>';

  foreach ($doc->getElementsByTagName('track') as $node) {

    $t_song = $node->getElementsByTagName('name')->item(0);
	$t_artist = $node->getElementsByTagName('artist')->item(0); 
    $t_url = $node->getElementsByTagName('url')->item(0);
    $song = $t_song->nodeValue;	
	$artist = $t_artist->nodeValue;	
	$url = $t_url->nodeValue;	
 
    $lastfmdisp .= '<li><font color="#000000" size="2"><a href="'.$url.'">'.$song.' - '.$artist.'</a></font></li>';
 
    if($i++ >= $max_tracks) break;
  }

if ($supportplugin=="Yes" || $supportplugin=="") {
$lastfmdisp .= "<p style='font-size:x-small'>Plugin created by <a href='http://www.jakeruston.co.uk'>Jake Ruston</a>.</p>";
}

$lastfmdisp .= "</ul></div>";
echo $lastfmdisp;

update_option("mt_lastfm_cachey", $lastfmdisp);

}

}

}

}

function show_lastfm_top() {
  $widget_title = get_option("mt_lastfm_title"); 
  $widget_title2 = get_option("mt_lastfm_title2");
  $max_tracks = get_option("mt_lastfm_limit");  
  $optionlastfm = get_option("mt_lastfm_account");
  $supportplugin = get_option("mt_lastfm_plugin_support"); 
  $optionlastfmcache = get_option("mt_lastfm_cache");
if (!$optionlastfm=="") {

$widget_title2=str_replace("%user%", $optionlastfm, $widget_title2);

$doc = new DOMDocument();
 
if($doc->load('http://ws.audioscrobbler.com/2.0/?method=user.getTopTracks&user='.$optionlastfm.'&period=overall&api_key=493bd628f307f4c4d268f24ab5239472')) {
 
  $i = 1;

$cachey2 = get_option("mt_lastfm_cachey2");

if (!$cachey2=="") {
if (!$optionlastfmcache=="0") {
echo $cachey2;

lastfm_delete_cache();
}

} else {
$lastfmdisp="";

  $lastfmdisp .= '<div id="recent-posts-4" class="widget widget_recent_entries"><h3>'; 

  $lastfmdisp .= $widget_title2.'</h3><ul>';

  foreach ($doc->getElementsByTagName('track') as $node) {

    $t_song = $node->getElementsByTagName('name')->item(0);
	$t_playcount = $node->getElementsByTagName('playcount')->item(0); 
    $t_url = $node->getElementsByTagName('url')->item(0);
    $song = $t_song->nodeValue;	
	$playcount = $t_playcount->nodeValue;	
	$url = $t_url->nodeValue;	
 
    $lastfmdisp .= '<li><font color="#000000" size="2"><a href="'.$url.'">'.$song.' - '.$playcount.' Plays</a></font></li>';
 
    if($i++ >= $max_tracks) break;
  }

if ($supportplugin=="Yes" || $supportplugin=="") {
$lastfmdisp .= "<p style='font-size:x-small'>Plugin created by <a href='http://www.jakeruston.co.uk'>Jake Ruston</a>.</p>";
}

$lastfmdisp .= "</ul></div>";
echo $lastfmdisp;

update_option("mt_lastfm_cachey2", $lastfmdisp);

}

}

}

}

function init_lastfm_widget() {
register_sidebar_widget("JR Last.FM Latest Tracks", "show_lastfm_latest");
register_sidebar_widget("JR Last.FM Top Tracks", "show_lastfm_top");
}

add_action("plugins_loaded", "init_lastfm_widget");

?>
