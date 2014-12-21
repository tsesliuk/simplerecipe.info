=== Image Pro - Image resizing and media management done right ===
Contributors: mihaivalentin
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SGRFS9EVFAFQU
Tags: post, plugin, image, images, pictures, editor, upload, management, frames, caption, borders
Requires at least: 3.0.0
Tested up to: 3.9
Stable tag: 0.35

Upload, resize, add, change images instantly. Manage your media collection with ease and use it for any post or page. A new way of managing content!

== Description ==

NEW: update to 0.34 to get:

*   frames for your pictures (rounded corners, polaroid and round frame)
*   captions for your pictures

Check out the 2 minute video presentation of this plugin:
http://www.mihaivalentin.com/image-pro-wordpress-image-management/

Image Pro simplifies the WordPress image upload, resize and management.

Using ImagePro, you can:

*   upload of multiple files directly from your desktop
*   perform smooth image resize (a perfect resize is created based on your resized picture in the editor)
*   easily manage the media collection (search, filter by file type)
*   drag and drop any image to the post and have it resized the way you want

== Installation ==

This plugin was developed and fully tested with:

- PHP 5.3.1 (should work on any PHP version >= 5.2, just make sure json_encode and json_decode are available)
- PHP GD Library (used for creating thumbnails)
- high memory_limit for PHP (useful when uploading large high-resolution images)
- Apache 2.2.1.4
- WordPress 3.2.1 (should work on any WordPress >= 3.0)
- Firefox >= 10 or Chrome >= 26 or Internet Explorer >= 10

Installation steps:

1. Extract the contents of the archive in the wp-content/plugins directory of your WordPress installation
2. Make sure the following paths are writable:
   - wp-content/plugins/imagepro/src/thumb/cache
   - wp-content/uploads and ALL its subfolders
3. Go to Dashboard -> Plugins and activate Image Pro Plugin
4. Go to any post or page and start using it

If you encounter issues with this plugin, please use the "DBG" link from the "Available Images" panel in the post editor. This will provide debugging information, which you can send back to me for troubleshooting.

== Arbitrary section ==

In case of experiencing problems, make sure you adhere to the installation requirements.
If the problem still persists, take a look at /imagepro/logs/impro.log and see if there are any errors or warnings reported
If nothing helps, please use the "DBG" link from the "Available Images" panel in the post editor. This will provide debugging information, which you can send back to me for troubleshooting.

Many thanks to phpThumb and KLogger. Also, many thanks to <Andrew Kurtis> from <webhostinghub.com> for the Spanish translation of the plugin!

Last but not least, great thanks to Jetbrains for their great PhpStorm IDE!

== Screenshots ==

1. Drag and drop media directly from your desktop (check http://www.mihaivalentin.com/image-pro-wordpress-image-management/ for a movie on how this plugin works - 2min)
2. Drag and drop media directly to your post or page  (check http://www.mihaivalentin.com/image-pro-wordpress-image-management/ for a movie on how this plugin works - 2min)
3. Just click to select an image and it's properties will appear in the right side of your post  (check http://www.mihaivalentin.com/image-pro-wordpress-image-management/ for a movie on how this plugin works - 2min)
4. Image resizing (1 - click the image, 2 - drag the resize handles, 3 - release)  (check http://www.mihaivalentin.com/image-pro-wordpress-image-management/ for a movie on how this plugin works - 2min)
5. Image align (1 - left, 2 - right, 3 - none)  (check http://www.mihaivalentin.com/image-pro-wordpress-image-management/ for a movie on how this plugin works - 2min)
6. General plugin overview (1 - media library, 2 - image properties)  (check http://www.mihaivalentin.com/image-pro-wordpress-image-management/ for a movie on how this plugin works - 2min)

== Changelog ==

= 0.35 =
* fixed plugin issues when used with themes that change $.ajax, such as Elemin theme
* fixed the "undefined" alert appearing when editing media

= 0.34 =
* Added image frames support (rounded corners, polaroid, round frame)
* Added image captions support
* Major refactoring of the frontend

= 0.33 =
* Made compatible with WordPress 3.9

= 0.32 =
* Fixed uploading by drag and drop from WordPress Add Media dialog
* Fixed missing images from "Available Images" that occurred as a result of errors breaking the JSON output

= 0.31 =
* Added Spanish translation. It was translated by "Andrew Kurtis" from "webhostinghub.com". Thanks!
* Disabled deprecated errors until I will find a way to replace PHPThumb with something newer

= 0.30 =
* Fixed a small bug causing removed images not closing the editing panel

= 0.29 =
* Fixed a progress bar bug that was not reporting the progress correctly in some conditions after release 0.28

= 0.28 =
* Images are responsive by default. They will resize nicely on lower resolution devices
* Their size can be now chosen according to predefined presets or just typed in manually
* Freely scalable: you can get past the responsive restriction set by your theme
* A better UI, lots of bugfixes and usability improvements

= 0.27 =
* Image Pro is now compatible with Internet Explorer 10 and Internet Explorer 11 as well. Also, when dragging an image from the "Available images" to the post editor, the "Selected image" options panel is automatically expanded in the right

= 0.26 =
* Clean all output buffers before thumbnail rendering. Before, only one was cleared, so that if more plugins were registered for output buffering processing, the thumbnail rendering would not work properly. Also improved "DBG" section by adding more information, especially about the document root and readability.

= 0.25 =
* Fixed an issue with thumbnails not showing due to the url parsing order of parameters given to phpThumb on some
 configurations.

= 0.24 =
* Fixed issues with thumbnails not showing when plugins like WP-Minify were active and stripping down jpeg thumb output. If your thumbs did not work properly before, make sure you delete what's inside the src/thumb/cache/* folder after update.

= 0.23 =
* Compatibility update: Fixed an issue preventing some users to view the thumbnails.

= 0.22 =
* Added the "DBG" (Debug) link from the "Available Images" panel in the post editor. This will provide deubugging information, which you can send back to me for troubleshooting. This feature is a very early development, aiming to fix incompatibilities with some webhosting/conflicting plugins.

= 0.21 =
* links on the image now open in a new page

= 0.20 =
* implemented links on images - big images can be opened when clicking on the resized ones, if the option "Open the full picture on click" is used

= 0.19 =
* fixed Image Pro conflict with other plugins using phpThumb

= 0.18 =
* made Image Pro work on WebKit browsers (Chrome, Safari)

= 0.17 =
* fixed a PHP 5.4 programming issue. Image Pro now works well with PHP 5.4

= 0.16 =
* plugin now supports multiple languages and can be localized. imagepro.pot file is in /languages/ folder
* fixed a bug related to KLogger class name collision with other plugins that also used KLogger for logging
* minor bug fixes

= 0.15 =
* fixed a bug that when linking a resized image to it's full image, the link would also be resized. Now the link remain as it is.
* fixed a bug that allowed some external plugins to add query filters when getting images, resulting in empty results. Now the Available images is completely independent of any other plugins installed.

= 0.14 =
* WordPress 3.3 fully compatible
* Support for transparent PNGs (no longer converts transparency to white)

= 0.12 =
* plugin also shows up in any custom post types, and not only in page and post

= 0.11 =
* Firefox 7 fully compatible (fixed an error in the drag and drop upload)

== Upgrade Notice ==

= 0.34 =
Update to get frame support and caption support.

= 0.28 =
Recommended update. Lots of improvements in various areas.

= 0.14 =
Please update! This plugin is now compatible with WordPress 3.3. 
