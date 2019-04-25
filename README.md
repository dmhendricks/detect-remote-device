[![Author](https://img.shields.io/badge/author-Daniel%20M.%20Hendricks-lightgrey.svg?colorB=9900cc)](https://daniel.hn/?utm_source=github.com&utm_medium=campaign&utm_content=button&utm_campaign=dmhendricks%2Fdetect-remote-device)
[![GitHub License](https://img.shields.io/badge/license-GPLv2-yellow.svg)](https://raw.githubusercontent.com/dmhendricks/detect-remote-device/master/LICENSE)
[![BrowserStack Status](https://www.browserstack.com/automate/badge.svg?badge_key=dmFTRkE3MlplYlB6djZyeWVyOU9XVmVEUjBqMjRpc3dXU3Z0QnM5WEhjVT0tLW9FN2tFYWkzZmdId295YjhKRC9aM3c9PQ==--1d6690824fc2a396d950cd61ec80eab2376b0c50)](https://www.browserstack.com/automate/public-build/dmFTRkE3MlplYlB6djZyeWVyOU9XVmVEUjBqMjRpc3dXU3Z0QnM5WEhjVT0tLW9FN2tFYWkzZmdId295YjhKRC9aM3c9PQ==--1d6690824fc2a396d950cd61ec80eab2376b0c50?utm_source=github.com&utm_medium=referral&utm_content=button&utm_campaign=dmhendricks%2Fdetect-remote-device)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/dmhendricks/detect-remote-device.svg?style=social)](https://twitter.com/danielhendricks)

# Detect Remote Device Plugin for WordPress

This WordPress plugin is uses the [Agent](https://github.com/jenssegers/agent) and [DeviceDetector](https://github.com/matomo-org/device-detector) PHP libraries to extend `wp_is_mobile()` to (optionally) exclude tablets and add device-specific filters and shortcodes. It was inspired by [Pothi Kalimuthu's](https://www.tinywp.in/?utm_source=github.com&utm_medium=campaign&utm_content=button&utm_campaign=detect-mobile-device) [Mobile Detect](https://wordpress.org/plugins/tinywp-mobile-detect/) plugin.

### Special Thanks

I would like to thank [BrowserStack](http://browserstack.com/?utm_source=github.com&utm_medium=referral&utm_content=link&utm_campaign=dmhendricks%2Fdetect-remote-device) for graciously allowing me to test this plugin's device detection on their platform. If you're looking for seamless application and browser testing  for your projects, give them a try:

[![App and Browser Testing Made Easy](https://f001.backblazeb2.com/file/hendricks/images/github/brands/browserstack/browserstack-logo-350x98.png)](http://browserstack.com/?utm_source=github.com&utm_medium=referral&utm_content=logo&utm_campaign=dmhendricks%2Fdetect-remote-device)

## Requirements

- WordPress 4.7 or higher
- PHP 5.6 or higher

If you're not sure if you meet these requirements, the plugin will tell you upon activation.

#### TODO

- [x] Add [OS-specific detection](https://github.com/jenssegers/agent)
- [ ] Add `[browser_agent_is]` shortcode
- [x] Add querystring modifiers
- [x] Add support for getting device type from request headers

### Installation

Download the distributable ZIP file from the [Releases](https://github.com/dmhendricks/detect-mobile-device/releases) page and install as you normally do for a WordPress plugin.

### Configuration

The following constants are available to modify behavior. They may be defined in your `wp-config.php`:

- `DMD_DISABLE_GLOBAL_FUNCTIONS` - If defined as true, [global functions](#option-2---global-functions) will not be created.
- `DMD_DISABLE_SHORTCODES` - If defined as true, shortcodes will not be loaded. Useful if you only want this plugin to solely act as an autoloader for the [Agent](https://github.com/jenssegers/agent) and [DeviceDetector](https://github.com/matomo-org/device-detector) PHP libraries.
- `DMD_ADD_DEVICE_TYPE_BODY_CLASSES` - Add device type body classes (default: true)
- `DMD_ADD_PLATFORM_BODY_CLASSES` - Add remote platform/OS body classes (default: false)
- `DMD_BODY_CLASS_PREFIX` - If defined, modifies the prefix added to device body classes.
- `DMD_MODIFY_WP_IS_MOBILE` - Modifies WordPress's built-in [`wp_is_mobile()`](https://codex.wordpress.org/Function_Reference/wp_is_mobile) function to return false for tablets.

#### Configuration Examples

```php
define( 'DMD_DISABLE_GLOBAL_FUNCTIONS', true );
define( 'DMD_DISABLE_SHORTCODES', false );
define( 'DMD_ADD_DEVICE_TYPE_BODY_CLASSES', false );
define( 'DMD_ADD_PLATFORM_BODY_CLASSES', true );
define( 'DMD_BODY_CLASS_PREFIX', 'screen' ); // Resulting body classes: screen-mobile, screen-desktop, etc
define( 'DMD_MODIFY_WP_IS_MOBILE', true );
```

## Usage

### Option 1 - Create MobileDetect Object

If desired, you can simply instantiate a new instance of [Agent](https://github.com/jenssegers/agent) or [DeviceDetector](https://github.com/matomo-org/device-detector). See each library's documentation for further usage examples.

```php
$device = new \Jenssegers\Agent\Agent;

if( $device->isTablet() ) {
	// Logic for tablets
} else if( $device->isMobile() ) {
	// Logic for phones
} else {
	// Logic for desktop
}
```

:rotating_light: **NB!** The `isMobile` method returns true for both phones _and_ tablets. In my example above, I check for tablets first, else if not tablet but is mobile, it is a phone. Adjust your logic as desired.

### Option 2 - Global Functions

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

#### Example Shortcode Usage

```
[device_is_phone]You're using a phone![/device_is_phone]

[device_is type="tablet,desktop"]You're using a tablet or desktop![/device_is]

[device_is_not type="phone"]You're NOT using a phone![/device_is_not]
```

[![Analytics](https://ga-beacon.appspot.com/UA-126205765-1/dmhendricks/detect-remote-device?flat)](https://ga-beacon.appspot.com/?utm_source=github.com&utm_medium=referral&utm_content=button&utm_campaign=dmhendricks%2Fdetect-remote-device)
