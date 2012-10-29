<?

/* 
	Plugin Name: Broadcast MU
	Description: Allows you to broadcast your post to multiple blogs on the same installation.
	Version: 1.0.1 
	Author: Tom Lynch 
	Author URI: http://unknowndomain.co.uk/
	Plugin URI: http://unknowndomain.co.uk/broadcast-mu

	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*
 *	BMU_compare
 *	-----------
 *	Used as part of the natural case-insensitive sort of the blog array in BMU_get_blogs_of_user().
 */
function BMU_compare($a, $b) {
	return strnatcasecmp($a['blogname'], $b['blogname']);
}

/*
 *	BMU_get_blogs_of_user
 *	---------------------
 *	Returns an array of blogs for the specified user (note it does not distinuguish between write and non-writeable blogs.
 */
function BMU_get_blogs_of_user($id) {
	$users_blogs = get_blogs_of_user($id);
	$i = 0;
	foreach ($users_blogs as $blog) {
		$output[$i]['userblog_id'] = $blog->userblog_id;
		$output[$i]['blogname'] = $blog->blogname;
		$output[$i]['domain'] = $blog->domain;
		$output[$i]['path'] = $blog->path;
		$output[$i]['site_id'] = $blog->site_id;
		$output[$i]['siteurl'] = $blog->siteurl;
		$i++;
	}	
	usort($output, "BMU_compare"); 
	return $output;
}

/*
 *	BMU_new_meta_boxes
 *	------------------
 *	Prints the meta box to the screen.
 */
function BMU_new_meta_boxes() {
	global $post, $new_meta_boxes, $current_user;
	
	get_currentuserinfo();	
	$users_blogs = BMU_get_blogs_of_user($current_user->ID);
	
	echo '<p>Post to:</p>';	
	
	foreach ($users_blogs as $blog):
	
		switch_to_blog($blog['userblog_id']);
		if (current_user_can('publish_posts')):
			restore_current_blog();
			?>
			<p><label <? if ($blog['siteurl'] != get_bloginfo('url')): ?>for="blog[<?= $blog['userblog_id'] ?>]"<? endif ?>><input type="checkbox" <? if ($blog['siteurl'] == get_bloginfo('url')): ?>checked="checked" disabled="disabled"<? else: ?>id="blog[<?= $blog['userblog_id'] ?>]" name="blog[<?= $blog['userblog_id'] ?>]"<? endif ?> /> <?= $blog['blogname'] ?></label></p>
	<?
		endif;
	
	endforeach;
}

/*
 *	BMU_create_meta_box
 *	-------------------
 *	Creates the meta box and tells Wordpress that BMU_new_meta_boxes will print the contents.
 */
function BMU_create_meta_box() {
	if ( function_exists('add_meta_box') ) {
		add_meta_box('BMU_new-meta-boxes', 'Broadcast', 'BMU_new_meta_boxes', 'post', 'side', 'low' );
	}
}

/*
 *	BMU_save_postdata
 *	-----------------
 *	Runs after the post has been saved and sends post to other blogs.
 */
function BMU_save_postdata($post_id) {
	if (did_action('save_post') <= count($_POST['blog'])-1) {
		global $current_user;
		get_currentuserinfo();	
		$users_blogs = BMU_get_blogs_of_user($current_user->ID);
		
		$post = get_post($post_id, 'ARRAY_A');
		$new_post['post_author'] = $post['post_author'];
		$new_post['post_date'] = $post['post_date'];
		$new_post['post_date_gmt'] = $post['post_date_gmt'];
		$new_post['post_content'] = $post['post_content'];
		$new_post['post_title'] = $post['post_title'];
		$new_post['post_category'] = $post['post_category'];
		$new_post['post_excerpt'] = $post['post_excerpt'];
		$new_post['post_status'] = $post['post_status'];
		$new_post['comment_status'] = $post['comment_status'];
		$new_post['ping_status'] = $post['ping_status'];
		$new_post['post_password'] = $post['post_password'];
		$new_post['post_name'] = $post['post_name'];
		$new_post['post_parent'] = $post['post_parent'];	
		
		foreach ($_POST['blog'] as $key => $value) {
			$output[] = $key;		
		}

		foreach ($users_blogs as $blog) {
			$in = array_search($blog['userblog_id'], $output);
			if (is_int($in)) {
				switch_to_blog($blog['userblog_id']);
				if (current_user_can('publish_posts')) do_action('save_post', wp_insert_post($new_post));
			}
		}
		restore_current_blog();
	}
}

if ($_REQUEST['action'] != 'edit') add_action('admin_menu', 'BMU_create_meta_box');  
if ($_REQUEST['action'] != 'edit') add_action('save_post', 'BMU_save_postdata');  

?>