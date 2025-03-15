# Migration Instructions for Sports Illustrated Theme

We've started the process of modularizing the Sports Illustrated theme by moving large sections of code from `functions.php` to separate files. Here are the steps to complete the migration:

## What's Been Done So Far

1. Created a modular structure in the `inc/` directory:
   - `theme-functions.php` - Main include file
   - `theme-setup.php` - Theme setup functions
   - `enqueue-scripts.php` - Script and style enqueuing
   - `widgets.php` - Widget-related functions
   - `menu-defaults.php` - Menu defaults and functions
   - `customizer/` directory with customizer-related files

2. Moved the following functions to their respective files:
   - `sports_illustrated_setup()` → `inc/theme-setup.php`
   - `sports_illustrated_enqueue_assets()` → `inc/enqueue-scripts.php`
   - `sports_illustrated_widgets_init()` → `inc/widgets.php`
   - `si_set_default_menu_values()` → `inc/menu-defaults.php`

3. Created a new streamlined `functions.php.new` file that includes the modular structure.

## Next Steps to Complete the Migration

1. **Move Customizer Functions**:
   - For each customizer section in `functions.php`, copy the relevant code to the corresponding file in `inc/customizer/`.
   - For example, move `si_home_page_customizer_settings()` to `inc/customizer/home-page.php`.

2. **Move Other Functions**:
   - Identify other large sections of code that can be modularized.
   - Create appropriate files in the `inc/` directory.
   - Move the code to these files.

3. **Update References**:
   - Ensure all function calls and references are updated to work with the new structure.

4. **Testing**:
   - Test each component after moving it to ensure functionality is maintained.

5. **Replace functions.php**:
   - Once all components are tested and working, replace the original `functions.php` with `functions.php.new`.
   - Make sure to add any remaining functions from the original file that haven't been modularized yet.

## Tips for a Successful Migration

1. **Work Incrementally**: Move one section at a time and test thoroughly before moving to the next.
2. **Keep Backups**: Always keep a backup of the original `functions.php` file.
3. **Check for Dependencies**: Some functions may depend on others, so be mindful of the order of inclusion.
4. **Update Hooks**: Make sure all action and filter hooks are preserved when moving functions.
5. **Test Thoroughly**: After each change, test the affected functionality to ensure it still works as expected.

## Final Steps

Once all the code has been moved and tested, you can replace the original `functions.php` with the new streamlined version. This will make your theme more maintainable and easier to work with in the future. 