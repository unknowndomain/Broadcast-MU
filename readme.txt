=== Broadcast MU ===
Contributors: ctsttom
Donate link: https://donate.cancerresearchuk.org/donate.asp
Tags: post, broadcast, multicast, wpmu, mu, blogs
Requires at least: 2.8.5.2
Tested up to: 2.8.6
Stable tag: 1.1.1

Broadcast MU is a plugin for WordPress MU which allows you to broadcast a post to one or more other blogs on the same installation of WordPress MU.

== Description ==

Broadcast MU is a plugin for WordPress MU which allows you to broadcast a post to one or more other blogs on the same installation of WordPress MU by simply checking the box next to those you wish to send it to.

You can enable this plugin on individual blogs or site wide.

This plugin is for WordPress MU only because regular WordPress only supports having one blog anyway.

NOTICE: Broadcast MU does not work when WordPress MU has post revisions enabled, you must disable them in your configuration by adding the following code to your wp-config.php... 

`define('WP_POST_REVISIONS', false);`

== Installation ==

1. Disable post revisions in your `wp-config.php` by adding `define('WP_POST_REVISIONS', false);`.

2. Upload `broadcast-mu.php` to the `/wp-content/plugins/` directory.

3. Activate the plugin through the `Plugins` menu in WordPress MU.

4. Create a new post from the `New Post` menu in WordPress MU and tick the blogs you want from the `Broadcast` box.

== Frequently Asked Questions ==

= Why is it showing loads of errors or not working? =
This is because of an incompatibility with another plugin or because you have not disabled post revisions by adding the following line of code to your `wp-config.php`... `define('WP_POST_REVISIONS', false);`

If the issue continues after adding that line, disable all plugins to see if it works still, then try turning them all back on one by one testing each time.

= Why can I only see some of the blogs on the site? =
This is because Broadcast MU only allows you to post to blogs which you have access to publish on.

= Can I enable the plugin for all users on my site? =
Yes, Either upload it to the `/wp-content/mu-plugins/` directory or in the `Plugins` menu in WordPress MU click 'Activate site wide'.

= Can I choose on which blogs my post will display? =
Yes, simply click the blogs you want when posting in WordPress.

= Can I modify or delete a post from all blogs simultaneously? =
No, once broadcasted they cannot be modified or deleted simultaneously however you can still go and change them manually.

== Screenshots ==

1. New post screen with the Broadcast MU meta box.
2. Close up of the Broadcast MU meta box.
3. Edit post screen with the Re-Broadcast meta box.
4. Close up of the Re-Broadcast meta box.

== Changelog ==

= 1.1.1 =
* Fixes a known issue where some installations of PHP do not allow short tags such as <? and <?= these have been substituted with <?php and <?php echo respectively.

= 1.1 =
* Adds a Re-Broadcast feature, so if you want to broadcast something after the original post was made you can just edit the post, select the blogs you want to Re-Broadcast to and then press update and then as well as the original post having its content updated if it was changed the other blogs will also receive the post (with its up-to-date content).

= 1.0.3 =
* Fixes incompatibility with the Domain Mapping plugin (was not printing the name of the blog).

= 1.0.2 =
* Fixes duplicate posting problem again - it really works this time, honest!

= 1.0.1 =
* Fixes duplicate posting problem and also a php typo.

= 1.0 =
* Initial release.

== Donate ==

Please donate whatever you can afford to Cancer Research UK, their work has saved literally thousands of lives and together we can beat cancer.

Thanks to Cancer Research UK and the NHS because without their help my families story could be a whole lot different right now.

If you want to show thanks for the work I have done making this plugin then  please donate.

Thanks.
