# Sports Illustrated Menu Manager

The Menu Manager provides an intuitive interface for managing restaurant menus within the WordPress admin area. It allows administrators to reset menu defaults individually or all at once, with a user-friendly interface.

## Features

- **Individual Menu Reset**: Reset specific menus (Full Menu, Drink Menu, Brunch Menu, Happy Hour Menu) to their default values without affecting other menus.
- **All Menus Reset**: Reset all menus to their default values at once.
- **Confirmation Dialogs**: Prevents accidental resets with confirmation dialogs.
- **Visual Feedback**: Clear visual feedback after reset operations.
- **Direct Customizer Access**: Quick links to the WordPress Customizer for menu editing.

## How to Use

1. Navigate to **Appearance > Menu Manager** in the WordPress admin.
2. Choose the menu you want to reset or select "Reset All Menus" to reset all menus.
3. Confirm the reset operation when prompted.
4. After the reset is complete, click the "Customize" button to edit the menu in the WordPress Customizer.

## Technical Details

The Menu Manager is implemented as a singleton class (`SI_Menu_Manager`) that:

- Registers a submenu page under the Appearance menu
- Handles AJAX requests for menu reset operations
- Provides a user-friendly interface with cards for each menu type
- Uses WordPress nonces for security
- Leverages the existing `si_set_default_menu_values()` function for setting defaults

## File Structure

- `inc/class-si-menu-manager.php`: The main class file
- `assets/css/admin/menu-manager.css`: Styles for the menu manager page
- `assets/js/admin/menu-manager.js`: JavaScript for handling AJAX requests and UI interactions

## Customization

To add additional menu types to the manager, modify the `$menu_types` array in the `SI_Menu_Manager` class. 