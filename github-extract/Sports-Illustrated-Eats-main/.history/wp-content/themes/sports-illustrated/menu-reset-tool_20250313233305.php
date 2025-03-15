<?php
/**
 * Menu Reset Tool
 * 
 * A comprehensive tool to reset and manage menu defaults.
 */

// Load WordPress
require_once(dirname(dirname(dirname(__FILE__))) . '/wp-load.php');

// Check if user is logged in and has permissions
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

// Process form submission
$message = '';
$message_type = '';

if (isset($_POST['action'])) {
    // Get the action
    $action = sanitize_text_field($_POST['action']);
    
    // Handle different actions
    switch ($action) {
        case 'reset_all':
            // Delete the option to allow defaults to be set again
            delete_option('si_default_menus_set');
            
            // Call the function to set defaults
            if (function_exists('si_set_default_menu_values')) {
                si_set_default_menu_values();
                $message = 'All menu defaults have been reset successfully.';
                $message_type = 'success';
            } else {
                $message = 'Error: The function to set menu defaults could not be found.';
                $message_type = 'error';
            }
            break;
            
        case 'reset_full':
            // Include the full menu defaults
            include_once(dirname(__FILE__) . '/includes/menu-defaults/full-menu-defaults.php');
            
            if (isset($full_defaults) && is_array($full_defaults)) {
                foreach ($full_defaults as $key => $value) {
                    set_theme_mod($key, $value);
                }
                $message = 'Full menu defaults have been reset successfully.';
                $message_type = 'success';
            } else {
                // If the include file doesn't exist or doesn't define $full_defaults, use inline defaults
                $full_defaults = array(
                    'si_written_menu_full_title' => 'FULL MENU',
                    'si_written_menu_full_description' => 'Served daily from 11am to 10pm',
                    // ... more defaults would be here
                );
                
                // Update theme mods
                foreach ($full_defaults as $key => $value) {
                    set_theme_mod($key, $value);
                }
                
                $message = 'Full menu defaults have been reset successfully (using inline defaults).';
                $message_type = 'success';
            }
            break;
            
        case 'reset_drinks':
            // Reset drinks menu defaults
            $drinks_defaults = array(
                'si_written_menu_drinks_title' => 'DRINKS MENU',
                'si_written_menu_drinks_description' => '',
                
                // Wine Section
                'si_written_menu_drinks_section_1_title' => 'Wine',
                'si_written_menu_drinks_section_1_description' => '',
                
                // White Wine Subsection
                'si_written_menu_drinks_section_1_item_1_name' => 'White',
                'si_written_menu_drinks_section_1_item_1_description' => '',
                'si_written_menu_drinks_section_1_item_1_price' => '',
                
                'si_written_menu_drinks_section_1_item_2_name' => 'Peller Estate Chardonnay',
                'si_written_menu_drinks_section_1_item_2_description' => 'Okanagan, Canada',
                'si_written_menu_drinks_section_1_item_2_price' => '9/12/32',
                
                // ... more drinks defaults would be here
            );
            
            // Update theme mods
            foreach ($drinks_defaults as $key => $value) {
                set_theme_mod($key, $value);
            }
            
            $message = 'Drinks menu defaults have been reset successfully.';
            $message_type = 'success';
            break;
            
        case 'reset_brunch':
            // Reset brunch menu defaults
            $brunch_defaults = array(
                'si_written_menu_brunch_title' => 'BRUNCH MENU',
                'si_written_menu_brunch_description' => 'Served 10 AM - 2 PM',
                
                // Breakfast Plates Section
                'si_written_menu_brunch_section_1_title' => 'Breakfast Plates',
                'si_written_menu_brunch_section_1_description' => '',
                
                'si_written_menu_brunch_section_1_item_1_name' => 'Classic Breakfast',
                'si_written_menu_brunch_section_1_item_1_description' => 'Two eggs any style, broiled tomato, herb fried potatoes<br>Choice of: Double Smoked Bacon | Apple Bangers | Avocado<br>Choice of: Sourdough Texas | Clubhouse Multigrain Toast',
                'si_written_menu_brunch_section_1_item_1_price' => '18',
                
                // ... more brunch defaults would be here
            );
            
            // Update theme mods
            foreach ($brunch_defaults as $key => $value) {
                set_theme_mod($key, $value);
            }
            
            $message = 'Brunch menu defaults have been reset successfully.';
            $message_type = 'success';
            break;
            
        case 'export_settings':
            // Export current menu settings
            $menu_types = array('full', 'drinks', 'brunch');
            $export_data = array();
            
            foreach ($menu_types as $menu_type) {
                $prefix = 'si_written_menu_' . $menu_type . '_';
                $all_mods = get_theme_mods();
                
                foreach ($all_mods as $key => $value) {
                    if (strpos($key, $prefix) === 0) {
                        $export_data[$key] = $value;
                    }
                }
            }
            
            // Output as JSON file for download
            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="menu-settings-export-' . date('Y-m-d') . '.json"');
            echo json_encode($export_data, JSON_PRETTY_PRINT);
            exit;
            break;
            
        case 'import_settings':
            // Import menu settings from uploaded JSON file
            if (isset($_FILES['import_file']) && $_FILES['import_file']['error'] == 0) {
                $file_content = file_get_contents($_FILES['import_file']['tmp_name']);
                $import_data = json_decode($file_content, true);
                
                if ($import_data && is_array($import_data)) {
                    foreach ($import_data as $key => $value) {
                        set_theme_mod($key, $value);
                    }
                    
                    $message = 'Menu settings have been imported successfully.';
                    $message_type = 'success';
                } else {
                    $message = 'Error: Invalid import file format.';
                    $message_type = 'error';
                }
            } else {
                $message = 'Error: No file uploaded or upload error.';
                $message_type = 'error';
            }
            break;
    }
}

// HTML for the tool interface
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu Reset Tool</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            background: #f1f1f1;
            color: #444;
            margin: 0;
            padding: 20px;
        }
        .wrap {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        h1 {
            color: #23282d;
            font-size: 23px;
            font-weight: 400;
            margin: 0 0 15px;
            padding: 9px 0 4px;
            line-height: 1.3;
        }
        .notice {
            background: #fff;
            border-left: 4px solid #fff;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            margin: 15px 0;
            padding: 12px;
        }
        .notice-success {
            border-left-color: #46b450;
        }
        .notice-error {
            border-left-color: #dc3232;
        }
        .card {
            background: #fff;
            border: 1px solid #e5e5e5;
            box-shadow: 0 1px 1px rgba(0,0,0,0.04);
            margin-top: 20px;
            max-width: 520px;
            padding: 0.7em 2em 1em;
            position: relative;
            margin-right: 20px;
            display: inline-block;
            vertical-align: top;
        }
        .card h2 {
            font-size: 14px;
            padding: 8px 12px;
            margin: 0;
            line-height: 1.4;
        }
        .button {
            display: inline-block;
            text-decoration: none;
            font-size: 13px;
            line-height: 2.15384615;
            min-height: 30px;
            margin: 0;
            padding: 0 10px;
            cursor: pointer;
            border-width: 1px;
            border-style: solid;
            -webkit-appearance: none;
            border-radius: 3px;
            white-space: nowrap;
            box-sizing: border-box;
            background: #f7f7f7;
            border-color: #ccc;
            color: #555;
            vertical-align: top;
        }
        .button-primary {
            background: #0085ba;
            border-color: #0073aa #006799 #006799;
            box-shadow: 0 1px 0 #006799;
            color: #fff;
            text-decoration: none;
            text-shadow: 0 -1px 1px #006799, 1px 0 1px #006799, 0 1px 1px #006799, -1px 0 1px #006799;
        }
        .button-primary:hover {
            background: #008ec2;
            border-color: #006799;
            color: #fff;
        }
        .button-danger {
            background: #d54e21;
            border-color: #d54e21;
            color: #fff;
        }
        .button-danger:hover {
            background: #c44;
            border-color: #c44;
            color: #fff;
        }
        form {
            margin-bottom: 20px;
        }
        .form-table {
            border-collapse: collapse;
            margin-top: 0.5em;
            width: 100%;
            clear: both;
        }
        .form-table th {
            vertical-align: top;
            text-align: left;
            padding: 20px 10px 20px 0;
            width: 200px;
            line-height: 1.3;
            font-weight: 600;
        }
        .form-table td {
            margin-bottom: 9px;
            padding: 15px 10px;
            line-height: 1.3;
            vertical-align: middle;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            flex: 1 0 300px;
            max-width: 100%;
            margin-right: 0;
        }
        .card-header {
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }
        .card-description {
            color: #666;
            font-style: italic;
            margin-bottom: 15px;
        }
        .card-actions {
            margin-top: 20px;
        }
        .import-export-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>Menu Reset Tool</h1>
        
        <?php if ($message): ?>
            <div class="notice notice-<?php echo $message_type; ?>">
                <p><?php echo $message; ?></p>
            </div>
        <?php endif; ?>
        
        <p>Use this tool to reset menu defaults or manage menu settings. Select an option below:</p>
        
        <div class="card-container">
            <!-- Reset All Menus Card -->
            <div class="card">
                <div class="card-header">
                    <h2>Reset All Menus</h2>
                </div>
                <div class="card-description">
                    <p>This will reset all menu defaults (Full Menu, Drinks Menu, and Brunch Menu) to their original values.</p>
                </div>
                <div class="card-actions">
                    <form method="post">
                        <input type="hidden" name="action" value="reset_all">
                        <button type="submit" class="button button-danger" onclick="return confirm('Are you sure you want to reset ALL menu defaults? This cannot be undone.');">Reset All Menus</button>
                    </form>
                </div>
            </div>
            
            <!-- Reset Full Menu Card -->
            <div class="card">
                <div class="card-header">
                    <h2>Reset Full Menu</h2>
                </div>
                <div class="card-description">
                    <p>This will reset only the Full Menu defaults while preserving other menu settings.</p>
                </div>
                <div class="card-actions">
                    <form method="post">
                        <input type="hidden" name="action" value="reset_full">
                        <button type="submit" class="button button-primary" onclick="return confirm('Are you sure you want to reset the Full Menu defaults? This cannot be undone.');">Reset Full Menu</button>
                    </form>
                </div>
            </div>
            
            <!-- Reset Drinks Menu Card -->
            <div class="card">
                <div class="card-header">
                    <h2>Reset Drinks Menu</h2>
                </div>
                <div class="card-description">
                    <p>This will reset only the Drinks Menu defaults while preserving other menu settings.</p>
                </div>
                <div class="card-actions">
                    <form method="post">
                        <input type="hidden" name="action" value="reset_drinks">
                        <button type="submit" class="button button-primary" onclick="return confirm('Are you sure you want to reset the Drinks Menu defaults? This cannot be undone.');">Reset Drinks Menu</button>
                    </form>
                </div>
            </div>
            
            <!-- Reset Brunch Menu Card -->
            <div class="card">
                <div class="card-header">
                    <h2>Reset Brunch Menu</h2>
                </div>
                <div class="card-description">
                    <p>This will reset only the Brunch Menu defaults while preserving other menu settings.</p>
                </div>
                <div class="card-actions">
                    <form method="post">
                        <input type="hidden" name="action" value="reset_brunch">
                        <button type="submit" class="button button-primary" onclick="return confirm('Are you sure you want to reset the Brunch Menu defaults? This cannot be undone.');">Reset Brunch Menu</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="import-export-section">
            <h2>Import/Export Menu Settings</h2>
            <p>Use these tools to backup your menu settings or transfer them between sites.</p>
            
            <div class="card-container">
                <!-- Export Settings Card -->
                <div class="card">
                    <div class="card-header">
                        <h2>Export Settings</h2>
                    </div>
                    <div class="card-description">
                        <p>Export all menu settings to a JSON file that you can use for backup or to import on another site.</p>
                    </div>
                    <div class="card-actions">
                        <form method="post">
                            <input type="hidden" name="action" value="export_settings">
                            <button type="submit" class="button">Export Menu Settings</button>
                        </form>
                    </div>
                </div>
                
                <!-- Import Settings Card -->
                <div class="card">
                    <div class="card-header">
                        <h2>Import Settings</h2>
                    </div>
                    <div class="card-description">
                        <p>Import menu settings from a previously exported JSON file.</p>
                    </div>
                    <div class="card-actions">
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="import_settings">
                            <input type="file" name="import_file" accept=".json">
                            <button type="submit" class="button" style="margin-top: 10px;">Import Menu Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <p style="margin-top: 30px;">
            <a href="<?php echo admin_url('customize.php?autofocus[section]=si_menu_display_section'); ?>" class="button">Go to Menu Customizer</a>
            <a href="<?php echo admin_url(); ?>" class="button">Return to Dashboard</a>
        </p>
    </div>
</body>
</html>
<?php
// End of file
?> 