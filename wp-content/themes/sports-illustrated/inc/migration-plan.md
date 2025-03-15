# Migration Plan for Sports Illustrated Theme

This document outlines the plan for migrating the Sports Illustrated theme from a monolithic `functions.php` file to a modular structure.

## Current Structure
- Large `functions.php` file (4360+ lines)
- Menu defaults in separate files (`brunch_menu_defaults.php`, `full_menu_defaults.php`, `drinks_menu_defaults.php`)
- Menu manager class in `inc/class-si-menu-manager.php`
- Menu manager integration in `inc/menu-manager-integration.php`

## New Structure
We've created a modular structure with the following components:

### Core Files
- `functions.php` - Minimal file that includes the main theme functions file
- `inc/theme-functions.php` - Main include file that loads all modular files

### Modular Files
- `inc/theme-setup.php` - Theme setup functions
- `inc/enqueue-scripts.php` - Script and style enqueuing
- `inc/widgets.php` - Widget-related functions
- `inc/menu-defaults.php` - Menu defaults include file

### Customizer Files
- `inc/customizer/customizer.php` - Main customizer include file
- `inc/customizer/home-page.php` - Home page customizer settings
- `inc/customizer/header-navigation.php` - Header navigation customizer settings
- `inc/customizer/footer.php` - Footer customizer settings
- `inc/customizer/page-backgrounds.php` - Page backgrounds customizer settings
- `inc/customizer/news-page.php` - News page customizer settings
- `inc/customizer/gift-cards.php` - Gift cards customizer settings
- `inc/customizer/catering.php` - Catering customizer settings
- `inc/customizer/contact.php` - Contact customizer settings
- `inc/customizer/menu-page.php` - Menu page customizer settings
- `inc/customizer/loading-screen.php` - Loading screen customizer settings
- `inc/customizer/monthly-events.php` - Monthly events customizer settings
- `inc/customizer/menu-display-type.php` - Menu display type customizer settings

## Migration Steps

1. **Backup the Current Theme**
   - Create a backup of the entire theme directory
   - Keep a copy of the original `functions.php` file

2. **Move Menu Defaults**
   - Ensure all menu default files are properly included in `inc/menu-defaults.php`
   - Update the `si_set_default_menu_values()` function to use the new structure

3. **Move Customizer Functions**
   - For each customizer section, copy the relevant code from `functions.php` to the corresponding file in `inc/customizer/`
   - Update any references to these functions

4. **Move Theme Setup Functions**
   - Copy the theme setup code from `functions.php` to `inc/theme-setup.php`

5. **Move Enqueue Functions**
   - Copy the script and style enqueuing code from `functions.php` to `inc/enqueue-scripts.php`

6. **Move Widget Functions**
   - Copy the widget initialization code from `functions.php` to `inc/widgets.php`

7. **Test Each Component**
   - After moving each component, test to ensure functionality is maintained

8. **Replace functions.php**
   - Once all components are tested and working, replace the original `functions.php` with the new streamlined version

9. **Final Testing**
   - Perform comprehensive testing of the entire theme
   - Check for any broken functionality or missing includes

## Notes
- This migration should be done incrementally, testing each component before moving to the next
- Keep the original `functions.php` file as a reference until the migration is complete
- Some functions may have dependencies on others, so the order of migration is important 