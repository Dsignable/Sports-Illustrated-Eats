<?php
/**
 * Restaurant Menus Editor
 *
 * Provides direct editing functionality for restaurant menus in the admin area.
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add AJAX handler for loading menu editor
 */
function si_load_menu_editor_ajax() {
    // Check nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'si_menu_manager_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'sports-illustrated')));
    }
    
    // Check if menu type is provided
    if (!isset($_POST['menu_type']) || empty($_POST['menu_type'])) {
        wp_send_json_error(array('message' => __('Menu type not specified.', 'sports-illustrated')));
    }
    
    $menu_type = sanitize_text_field($_POST['menu_type']);
    $allowed_types = array('drinks', 'brunch', 'full');
    
    if (!in_array($menu_type, $allowed_types)) {
        wp_send_json_error(array('message' => __('Invalid menu type.', 'sports-illustrated')));
    }
    
    // Include menu defaults
    require_once get_template_directory() . '/inc/menu-defaults.php';
    
    // Get menu defaults
    $defaults = si_get_menu_defaults($menu_type);
    
    // Get menu title
    $menu_title = get_theme_mod("si_written_menu_{$menu_type}_title", $defaults["si_written_menu_{$menu_type}_title"] ?? '');
    $menu_description = get_theme_mod("si_written_menu_{$menu_type}_description", $defaults["si_written_menu_{$menu_type}_description"] ?? '');
    
    // Start output buffer
    ob_start();
    
    // Menu editor form
    ?>
    <div class="si-menu-editor-form" data-menu-type="<?php echo esc_attr($menu_type); ?>">
        <div class="si-menu-editor-header">
            <h2><?php echo sprintf(__('Edit %s', 'sports-illustrated'), ucfirst($menu_type) . ' Menu'); ?></h2>
            <p class="description"><?php echo __('Make changes to your menu items below. Click "Save Changes" when finished.', 'sports-illustrated'); ?></p>
        </div>
        
        <div class="si-menu-editor-fields">
            <div class="si-menu-editor-field">
                <label for="si_menu_title"><?php echo __('Menu Title', 'sports-illustrated'); ?></label>
                <input type="text" id="si_menu_title" name="si_written_menu_<?php echo esc_attr($menu_type); ?>_title" value="<?php echo esc_attr($menu_title); ?>" class="regular-text">
                <p class="description"><?php echo sprintf(__('Default: %s', 'sports-illustrated'), $defaults["si_written_menu_{$menu_type}_title"] ?? ''); ?></p>
            </div>
            
            <div class="si-menu-editor-field">
                <label for="si_menu_description"><?php echo __('Menu Description', 'sports-illustrated'); ?></label>
                <textarea id="si_menu_description" name="si_written_menu_<?php echo esc_attr($menu_type); ?>_description" rows="3" class="large-text"><?php echo esc_textarea($menu_description); ?></textarea>
                <?php if (!empty($defaults["si_written_menu_{$menu_type}_description"])): ?>
                    <p class="description"><?php echo sprintf(__('Default: %s', 'sports-illustrated'), $defaults["si_written_menu_{$menu_type}_description"]); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="si-menu-editor-sections">
            <?php
            // Loop through sections (up to 10)
            for ($i = 1; $i <= 10; $i++) {
                $section_id = "si_written_menu_{$menu_type}_section_{$i}";
                $section_title = get_theme_mod("{$section_id}_title", $defaults["{$section_id}_title"] ?? '');
                
                // Skip empty sections after section 3
                if ($i > 3 && empty($section_title) && empty($defaults["{$section_id}_title"])) {
                    continue;
                }
                
                $section_description = get_theme_mod("{$section_id}_description", $defaults["{$section_id}_description"] ?? '');
                ?>
                <div class="si-menu-editor-section" data-section="<?php echo esc_attr($i); ?>">
                    <div class="si-menu-editor-section-header">
                        <h3><?php echo sprintf(__('Section %d', 'sports-illustrated'), $i); ?></h3>
                        <div class="si-menu-editor-section-actions">
                            <button type="button" class="button si-toggle-section" data-section="<?php echo esc_attr($i); ?>">
                                <span class="dashicons dashicons-arrow-down-alt2"></span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="si-menu-editor-section-content">
                        <div class="si-menu-editor-field">
                            <label for="<?php echo esc_attr($section_id); ?>_title"><?php echo __('Section Title', 'sports-illustrated'); ?></label>
                            <input type="text" id="<?php echo esc_attr($section_id); ?>_title" name="<?php echo esc_attr($section_id); ?>_title" value="<?php echo esc_attr($section_title); ?>" class="regular-text">
                            <?php if (!empty($defaults["{$section_id}_title"])): ?>
                                <p class="description"><?php echo sprintf(__('Default: %s', 'sports-illustrated'), $defaults["{$section_id}_title"]); ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="si-menu-editor-field">
                            <label for="<?php echo esc_attr($section_id); ?>_description"><?php echo __('Section Description', 'sports-illustrated'); ?></label>
                            <textarea id="<?php echo esc_attr($section_id); ?>_description" name="<?php echo esc_attr($section_id); ?>_description" rows="2" class="large-text"><?php echo esc_textarea($section_description); ?></textarea>
                            <?php if (!empty($defaults["{$section_id}_description"])): ?>
                                <p class="description"><?php echo sprintf(__('Default: %s', 'sports-illustrated'), $defaults["{$section_id}_description"]); ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="si-menu-editor-items">
                            <h4><?php echo __('Menu Items', 'sports-illustrated'); ?></h4>
                            
                            <table class="widefat si-menu-items-table">
                                <thead>
                                    <tr>
                                        <th class="si-item-name"><?php echo __('Name', 'sports-illustrated'); ?></th>
                                        <th class="si-item-description"><?php echo __('Description', 'sports-illustrated'); ?></th>
                                        <th class="si-item-price"><?php echo __('Price', 'sports-illustrated'); ?></th>
                                        <th class="si-item-notes"><?php echo __('Notes', 'sports-illustrated'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Loop through items (up to 20)
                                    for ($j = 1; $j <= 20; $j++) {
                                        $item_id = "{$section_id}_item_{$j}";
                                        $item_name = get_theme_mod("{$item_id}_name", $defaults["{$item_id}_name"] ?? '');
                                        
                                        // Skip empty items after item 5
                                        if ($j > 5 && empty($item_name) && empty($defaults["{$item_id}_name"])) {
                                            continue;
                                        }
                                        
                                        $item_description = get_theme_mod("{$item_id}_description", $defaults["{$item_id}_description"] ?? '');
                                        $item_price = get_theme_mod("{$item_id}_price", $defaults["{$item_id}_price"] ?? '');
                                        $item_notes = get_theme_mod("{$item_id}_notes", $defaults["{$item_id}_notes"] ?? '');
                                        
                                        $is_subsection = ($item_notes === 'subsection');
                                        $row_class = $is_subsection ? 'si-subsection-row' : '';
                                        ?>
                                        <tr class="<?php echo esc_attr($row_class); ?>" data-item="<?php echo esc_attr($j); ?>">
                                            <td class="si-item-name">
                                                <input type="text" name="<?php echo esc_attr($item_id); ?>_name" value="<?php echo esc_attr($item_name); ?>" placeholder="<?php echo esc_attr__('Item name', 'sports-illustrated'); ?>">
                                                <?php if (!empty($defaults["{$item_id}_name"])): ?>
                                                    <p class="description"><?php echo sprintf(__('Default: %s', 'sports-illustrated'), $defaults["{$item_id}_name"]); ?></p>
                                                <?php endif; ?>
                                            </td>
                                            <td class="si-item-description">
                                                <textarea name="<?php echo esc_attr($item_id); ?>_description" rows="2" placeholder="<?php echo esc_attr__('Item description', 'sports-illustrated'); ?>"><?php echo esc_textarea($item_description); ?></textarea>
                                                <?php if (!empty($defaults["{$item_id}_description"])): ?>
                                                    <p class="description"><?php echo sprintf(__('Default: %s', 'sports-illustrated'), $defaults["{$item_id}_description"]); ?></p>
                                                <?php endif; ?>
                                            </td>
                                            <td class="si-item-price">
                                                <input type="text" name="<?php echo esc_attr($item_id); ?>_price" value="<?php echo esc_attr($item_price); ?>" placeholder="<?php echo esc_attr__('Price', 'sports-illustrated'); ?>">
                                                <?php if (!empty($defaults["{$item_id}_price"])): ?>
                                                    <p class="description"><?php echo sprintf(__('Default: %s', 'sports-illustrated'), $defaults["{$item_id}_price"]); ?></p>
                                                <?php endif; ?>
                                            </td>
                                            <td class="si-item-notes">
                                                <input type="text" name="<?php echo esc_attr($item_id); ?>_notes" value="<?php echo esc_attr($item_notes); ?>" placeholder="<?php echo esc_attr__('Notes', 'sports-illustrated'); ?>">
                                                <label>
                                                    <input type="checkbox" class="si-subsection-toggle" <?php checked($is_subsection); ?>>
                                                    <?php echo __('Subsection', 'sports-illustrated'); ?>
                                                </label>
                                                <?php if (!empty($defaults["{$item_id}_notes"])): ?>
                                                    <p class="description"><?php echo sprintf(__('Default: %s', 'sports-illustrated'), $defaults["{$item_id}_notes"]); ?></p>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            <button type="button" class="button si-add-item" data-section="<?php echo esc_attr($i); ?>">
                                                <?php echo __('Add Item', 'sports-illustrated'); ?>
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            
            <div class="si-menu-editor-actions">
                <button type="button" class="button si-add-section">
                    <?php echo __('Add Section', 'sports-illustrated'); ?>
                </button>
            </div>
        </div>
        
        <div class="si-menu-editor-footer">
            <div class="si-menu-editor-messages"></div>
            <div class="si-menu-editor-buttons">
                <button type="button" class="button button-primary si-save-menu" data-menu-type="<?php echo esc_attr($menu_type); ?>">
                    <?php echo __('Save Changes', 'sports-illustrated'); ?>
                    <span class="spinner"></span>
                </button>
                <button type="button" class="button si-cancel-edit">
                    <?php echo __('Cancel', 'sports-illustrated'); ?>
                </button>
            </div>
        </div>
    </div>
    <?php
    
    $output = ob_get_clean();
    wp_send_json_success(array('html' => $output));
}
add_action('wp_ajax_si_load_menu_editor', 'si_load_menu_editor_ajax');

/**
 * Add AJAX handler for saving menu
 */
function si_save_menu_ajax() {
    // Check nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'si_menu_manager_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'sports-illustrated')));
    }
    
    // Check if menu type is provided
    if (!isset($_POST['menu_type']) || empty($_POST['menu_type'])) {
        wp_send_json_error(array('message' => __('Menu type not specified.', 'sports-illustrated')));
    }
    
    $menu_type = sanitize_text_field($_POST['menu_type']);
    $allowed_types = array('drinks', 'brunch', 'full');
    
    if (!in_array($menu_type, $allowed_types)) {
        wp_send_json_error(array('message' => __('Invalid menu type.', 'sports-illustrated')));
    }
    
    // Check if form data is provided
    if (!isset($_POST['form_data']) || empty($_POST['form_data'])) {
        wp_send_json_error(array('message' => __('No form data provided.', 'sports-illustrated')));
    }
    
    // Parse form data
    parse_str($_POST['form_data'], $form_data);
    
    // Sanitize and save each field
    foreach ($form_data as $key => $value) {
        // Skip non-menu fields
        if (strpos($key, "si_written_menu_{$menu_type}") !== 0 && strpos($key, "si_written_menu_{$menu_type}_section_") !== 0) {
            continue;
        }
        
        // Sanitize value based on field type
        if (strpos($key, '_description') !== false) {
            $value = wp_kses_post($value);
        } else {
            $value = sanitize_text_field($value);
        }
        
        // Save to theme mod
        set_theme_mod($key, $value);
    }
    
    wp_send_json_success(array(
        'message' => sprintf(__('%s updated successfully.', 'sports-illustrated'), ucfirst($menu_type) . ' Menu')
    ));
}
add_action('wp_ajax_si_save_menu', 'si_save_menu_ajax');

/**
 * Add AJAX handler for resetting menu
 */
function si_reset_menu_ajax() {
    // Check nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'si_menu_manager_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'sports-illustrated')));
    }
    
    // Check if reset type is provided
    if (!isset($_POST['reset_type']) || empty($_POST['reset_type'])) {
        wp_send_json_error(array('message' => __('Reset type not specified.', 'sports-illustrated')));
    }
    
    $reset_type = sanitize_text_field($_POST['reset_type']);
    $allowed_types = array('drinks', 'brunch', 'full', 'all');
    
    if (!in_array($reset_type, $allowed_types)) {
        wp_send_json_error(array('message' => __('Invalid reset type.', 'sports-illustrated')));
    }
    
    // Include menu defaults
    require_once get_template_directory() . '/inc/menu-defaults.php';
    
    // Reset all menus
    if ($reset_type === 'all') {
        // Reset drinks menu
        $drinks_defaults = si_get_menu_defaults('drinks');
        foreach ($drinks_defaults as $key => $value) {
            set_theme_mod($key, $value);
        }
        
        // Reset brunch menu
        $brunch_defaults = si_get_menu_defaults('brunch');
        foreach ($brunch_defaults as $key => $value) {
            set_theme_mod($key, $value);
        }
        
        // Reset full menu
        $full_defaults = si_get_menu_defaults('full');
        foreach ($full_defaults as $key => $value) {
            set_theme_mod($key, $value);
        }
        
        wp_send_json_success(array(
            'message' => __('All menus have been reset to default values.', 'sports-illustrated')
        ));
    } else {
        // Reset specific menu
        $defaults = si_get_menu_defaults($reset_type);
        foreach ($defaults as $key => $value) {
            set_theme_mod($key, $value);
        }
        
        wp_send_json_success(array(
            'message' => sprintf(__('%s has been reset to default values.', 'sports-illustrated'), ucfirst($reset_type) . ' Menu')
        ));
    }
}
add_action('wp_ajax_si_reset_menu', 'si_reset_menu_ajax'); 