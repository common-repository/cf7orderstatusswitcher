=== CF7 Order Status Switcher ===
Contributors: eliodata
Tags: woocommerce, contact form 7, order status, order management, forms
Requires at least: 6.0
Tested up to: 6.1.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily manage Contact Form 7 forms on WooCommerce order detail pages and change order status upon form submission.

== Description ==

CF7 Order Status Switcher is a WordPress plugin that allows you to display specific Contact Form 7 forms on WooCommerce order detail pages based on the current order status. When a form is submitted, the plugin automatically updates the order status to the specified new status.

Some of the features of the plugin include:

* Easy configuration: Define form ID and associated order statuses on the plugin settings page in the WordPress admin area.
* Seamless integration: Display the selected Contact Form 7 form on the WooCommerce order detail page based on the order status.
* Automatic order status update: Update the order status automatically after form submission.
* Flexible: Add, edit or remove forms and associated order statuses as needed.

== Installation ==

1. Upload the `cf7-order-status-switcher` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to the CF7 Order Status Switcher settings page in the WordPress admin area to configure the plugin.

== Frequently Asked Questions ==

= Does this plugin require WooCommerce and Contact Form 7 to work? =

Yes, this plugin requires both WooCommerce and Contact Form 7 to be installed and activated on your WordPress site.

= Can I use this plugin to display different forms for different order statuses? =

Yes, you can configure different Contact Form 7 forms for different order statuses on the plugin settings page.

= How do I add a new form and order status pair? =

Go to the CF7 Order Status Switcher settings page in the WordPress admin area. Click on the "Add new" button and enter the Contact Form 7 form ID and the desired order statuses in the corresponding fields.

= Can I remove a form and order status pair? =

Yes, to remove a form and order status pair, go to the CF7 Order Status Switcher settings page in the WordPress admin area. Locate the pair you want to remove, and click on the "Delete" button.

= Can I edit an existing form and order status pair? =

Yes, to edit a form and order status pair, go to the CF7 Order Status Switcher settings page in the WordPress admin area. Locate the pair you want to edit, and update the Contact Form 7 form ID and/or order statuses in the corresponding fields.

= Does this plugin work with custom order statuses? =

Yes, CF7 Order Status Switcher works with both default WooCommerce order statuses and custom order statuses. When configuring the plugin, make sure to use the slug of the order status.

= Where are the forms displayed on the website? =

The selected Contact Form 7 forms are displayed on the WooCommerce order detail pages, which can be accessed at URLs like `/my-account/view-order/orderID`. Make sure your customers have access to these pages to view and submit the forms.

= How can I direct customers to the order detail page to fill out the form? =

We recommend including a link to the order detail page in the WooCommerce order notification emails. You can customize the email templates in WooCommerce settings and add a message with a link to the order detail page, inviting the customer to fill out the required form.

== Screenshots ==

WordPress plugins page showing the CF7 Order Status Switcher plugin installed.
Contact Form 7 form edit page highlighting the form ID.
CF7 Order Status Switcher settings page showcasing the use of order status slug and form ID.
Order details page with the form loaded and filled out, displaying the current order status.
Order details page showing the updated order status after form submission.

== Changelog ==

= 1.0 =

Initial release.
== Upgrade Notice ==
N/A

Tested Up To Value is Out of Date, Invalid, or Missing