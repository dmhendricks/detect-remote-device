[![Author](https://img.shields.io/badge/author-Daniel%20M.%20Hendricks-lightgrey.svg?colorB=9900cc&style=flat-square)](https://daniel.hn/?utm_source=github.com&utm_medium=campaign&utm_content=button&utm_campaign=detect-mobile-device)
[![GitHub License](https://img.shields.io/badge/license-GPLv2-yellow.svg?style=flat-square)](https://raw.githubusercontent.com/dmhendricks/detect-mobile-device/master/LICENSE)
[![Get Flywheel](https://img.shields.io/badge/hosting-Flywheel-green.svg?style=flat-square&label=compatible&colorB=AE2A21)](https://share.getf.ly/e25g6k?utm_source=github.com&utm_medium=campaign&utm_content=button&utm_campaign=dmhendricks%2Fdetect-mobile-device)
[![Analytics](https://ga-beacon.appspot.com/UA-126205765-1/dmhendricks/detect-mobile-device?flat)](https://ga-beacon.appspot.com/?utm_source=github.com&utm_medium=campaign&utm_content=button&utm_campaign=dmhendricks%2Fdetect-mobile-device)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/dmhendricks/detect-mobile-device.svg?style=social)](https://twitter.com/danielhendricks)

# Detect Mobile Device Plugin for WordPress

This WordPress plugin is uses the [MobileDetect](http://mobiledetect.net/) PHP library to extend `wp_is_mobile()` to exclude tablets and add device-specific filters and shortcodes. It was inspired by [Pothi Kalimuthu's](https://www.tinywp.in/?utm_source=github.com&utm_medium=campaign&utm_content=button&utm_campaign=detect-mobile-device) [Mobile Detect](https://wordpress.org/plugins/tinywp-mobile-detect/) plugin.

:bangbang: This is a work-in-progress. **This plugin _does not function_.**

## Requirements

- WordPress 4.7 or higher
- PHP 5.6 or higher

If you're not sure if you meet these requirements, the plugin will tell you upon activation.

### TODO

- [x] Add global functions
- [ ] Add shortcodes
- [x] Add device body classes
- [ ] Add all configuration constants
- [x] Add translation file
- [x] Modify [`wp_is_mobile()`](https://codex.wordpress.org/Function_Reference/wp_is_mobile) to return false if tablet, if enabled
- [ ] Add OS-specific global functions and shortcodes

### Installation

**TODO:** Download the release ZIP file (once available) and install as you normally would via the WP Admin plugins page.

### Configuration

The following constants are available to modify behavior. They may be defined in your `wp-config.php`:

- `DMD_DISABLE_GLOBAL_FUNCTIONS` - If defined as true, global functions will not be created.
- `DMD_DISABLE_SHORTCODES` - If defined as true, shortcodes will not be loaded. Useful if you only want this plugin to solely act as an autoloader for the [MobileDetect](http://mobiledetect.net/) PHP library.
- `DMD_BODY_CLASS_PREFIX` - If defined as string, modifies the prefix added to device body classes. If false, disables addition of body classes. Defaults to `device`.
- `DMD_MODIFY_WP_IS_MOBILE` - Modifies WordPress's built-in [`wp_is_mobile()`](https://codex.wordpress.org/Function_Reference/wp_is_mobile) function to return false for tablets.

#### Example Usage

```php
define( 'DMD_DISABLE_GLOBAL_FUNCTIONS', true );
define( 'DMD_DISABLE_SHORTCODES', false );
define( 'DMD_BODY_CLASS_PREFIX', 'remote' ); // Resulting body classes: remote-mobile, remote-desktop, etc
define( 'DMD_MODIFY_WP_IS_MOBILE', true );
```

## Usage

### Option 1 - Create MobileDetect Object

If desired, you can simply instantiate a new instance of [MobileDetect](http://mobiledetect.net/). See the class's documentation page for further usage examples.

```php
$device = new \Mobile_Detect();

if( $device->isTablet() ) {
	// Logic for tablets
} else if( $device->isMobile() ) {
	// Logic for phones
} else {
	// Logic for desktop
}
```

:rotating_light: **NB!** The `isMobile` method returns true for both phones _and_ tablets. In my example above, I check for tablets first, else if not tablet but is mobile, it is a phone. Adjust your logic as desired.

### Option 2 - Use Global Functions

To supplement WordPress's built-in [`wp_is_mobile()`](https://codex.wordpress.org/Function_Reference/wp_is_mobile) function (which returns true for phone _and_ tablet), this plugin adds functions to specifically detect phones and tablets:

```php
// Built-in WordPress function: Do something for phones AND tablets
if( wp_is_mobile() ) {
	// ...
}

// Custom global functions
if( device_is_phone() ) {
	// ... Phones only
} else if( device_is_tablet() ) {
	// ... Tablets only
} else if( device_is_desktop() ) {
	// ... Desktop only
} else {
    // ...
}

// Get device type as string
echo 'Device type: ' . get_the_device_type(); // Device type: tablet
```

### Option 3 - Use Shortcodes

This plugin adds the following shortcodes:

- `[device_is_mobile]` - Display content if **phone** or **tablet**
- `[device_is_phone]` - Display content if **phone**
- `[device_is_tablet]` - Display content if **tablet**
- `[device_is_desktop]` - Display content if **desktop**
- `[device_is type="tablet,phone"]` - Display content if `type` attribute matches. Multiple types may be separated by comma.
- `[device_is_not type="desktop"]` - Display content if `type` attribute **does not** match. Multiple types may be separated by comma.
- **More to come!**

:ok_hand: I realize that these can be consolidated into one shortcode, but I split them out for user semantics. Use them as you wish.
