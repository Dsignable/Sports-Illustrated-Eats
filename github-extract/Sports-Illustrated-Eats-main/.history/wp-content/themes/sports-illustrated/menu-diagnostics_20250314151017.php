<?php
/**
 * Menu Diagnostics Tool
 *
 * This script provides diagnostic information about the menu defaults.
 * To use, visit /wp-admin/themes.php?page=si-menu-manager&diagnostics=1
 *
 * @package Sports_Illustrated
 */

// Add a query parameter hook to show diagnostics
function si_menu_diagnostics() {
    if (isset($_GET['diagnostics']) && $_GET['diagnostics'] == 1 && current_user_can('edit_theme_options')) {
        // Add admin notice
        add_action('admin_notices', 'si_menu_diagnostics_notice');
        
        // Run diagnostics
        si_run_menu_diagnostics();
    }
}
add_action('admin_init', 'si_menu_diagnostics');

// Diagnostics notice
function si_menu_diagnostics_notice() {
    ?>
    <div class="notice notice-info is-dismissible">
        <p><?php _e('Menu diagnostics have been run. Please check the error log for details.', 'sports-illustrated'); ?></p>
    </div>
    <?php
}

// Run diagnostics
function si_run_menu_diagnostics() {
    error_log('=== MENU DIAGNOSTICS START ===');
    
    // Check if drinks_menu_defaults.php exists in inc directory
    $inc_file = get_template_directory() . '/inc/drinks_menu_defaults.php';
    error_log('Checking for inc/drinks_menu_defaults.php: ' . (file_exists($inc_file) ? 'EXISTS' : 'NOT FOUND'));
    
    // Check if drinks_menu_defaults.php exists in root directory
    $root_file = get_template_directory() . '/drinks_menu_defaults.php';
    error_log('Checking for drinks_menu_defaults.php: ' . (file_exists($root_file) ? 'EXISTS' : 'NOT FOUND'));
    
    // Check if si_set_drinks_menu_defaults function exists
    error_log('Checking for si_set_drinks_menu_defaults function: ' . (function_exists('si_set_drinks_menu_defaults') ? 'EXISTS' : 'NOT FOUND'));
    
    // Check if $drinks_defaults global array exists
    global $drinks_defaults;
    error_log('Checking for $drinks_defaults global array: ' . (isset($drinks_defaults) && is_array($drinks_defaults) ? 'EXISTS' : 'NOT FOUND'));
    
    // Check if drinks menu theme mods exist
    $title = get_theme_mod('si_written_menu_drinks_title', '');
    error_log('Checking for si_written_menu_drinks_title theme mod: ' . (!empty($title) ? 'EXISTS: ' . $title : 'NOT FOUND'));
    
    $section_1_title = get_theme_mod('si_written_menu_drinks_section_1_title', '');
    error_log('Checking for si_written_menu_drinks_section_1_title theme mod: ' . (!empty($section_1_title) ? 'EXISTS: ' . $section_1_title : 'NOT FOUND'));
    
    // Check if si_default_menus_set option exists
    $default_menus_set = get_option('si_default_menus_set', false);
    error_log('Checking for si_default_menus_set option: ' . ($default_menus_set ? 'EXISTS' : 'NOT FOUND'));
    
    // Try to include the drinks menu defaults file
    if (file_exists($inc_file)) {
        require_once $inc_file;
        error_log('Included inc/drinks_menu_defaults.php');
    } elseif (file_exists($root_file)) {
        require_once $root_file;
        error_log('Included drinks_menu_defaults.php');
    }
    
    // Check if si_set_drinks_menu_defaults function exists after including the file
    error_log('Checking for si_set_drinks_menu_defaults function after include: ' . (function_exists('si_set_drinks_menu_defaults') ? 'EXISTS' : 'NOT FOUND'));
    
    // Check if $drinks_defaults global array exists after including the file
    error_log('Checking for $drinks_defaults global array after include: ' . (isset($drinks_defaults) && is_array($drinks_defaults) ? 'EXISTS' : 'NOT FOUND'));
    
    error_log('=== MENU DIAGNOSTICS END ===');
}

// Add diagnostics link to the menu manager page
function si_add_diagnostics_link() {
    global $pagenow;
    
    if ($pagenow === 'themes.php' && isset($_GET['page']) && $_GET['page'] === 'si-menu-manager') {
        ?>
        <div class="wrap">
            <p>
                <a href="<?php echo esc_url(admin_url('themes.php?page=si-menu-manager&diagnostics=1')); ?>" class="button">
                    <?php _e('Run Menu Diagnostics', 'sports-illustrated'); ?>
                </a>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'si_add_diagnostics_link'); 