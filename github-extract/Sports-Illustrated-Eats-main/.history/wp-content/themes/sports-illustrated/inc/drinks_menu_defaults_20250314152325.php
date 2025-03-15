<?php
/**
 * Drinks Menu Defaults
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Set default values for the drinks menu
 */
function si_set_drinks_menu_defaults() {
    // Debug log
    error_log('si_set_drinks_menu_defaults function called from inc directory');
    
    global $drinks_defaults;
    
    // Check if the global array is available
    if (isset($drinks_defaults) && is_array($drinks_defaults)) {
        // Set each theme mod from the array
        foreach ($drinks_defaults as $key => $value) {
            set_theme_mod($key, $value);
        }
        error_log('Set drinks menu defaults using global array');
    } else {
        // Menu title and description
        set_theme_mod('si_written_menu_drinks_title', 'DRINKS MENU');
        set_theme_mod('si_written_menu_drinks_description', '');

        // Section 1: Wine
        set_theme_mod('si_written_menu_drinks_section_1_title', 'Wine');
        set_theme_mod('si_written_menu_drinks_section_1_description', '');
        
        // White Wine Subsection (first, matching root file)
        set_theme_mod('si_written_menu_drinks_section_1_item_1_name', 'White');
        set_theme_mod('si_written_menu_drinks_section_1_item_1_description', 'Glass / Half Litre / Bottle');
        set_theme_mod('si_written_menu_drinks_section_1_item_1_price', '');
        set_theme_mod('si_written_menu_drinks_section_1_item_1_notes', 'subsection');
        
        set_theme_mod('si_written_menu_drinks_section_1_item_2_name', 'Peller Estate Chardonnay');
        set_theme_mod('si_written_menu_drinks_section_1_item_2_description', 'Okanagan, Canada');
        set_theme_mod('si_written_menu_drinks_section_1_item_2_price', '9/12/32');
            
        set_theme_mod('si_written_menu_drinks_section_1_item_3_name', 'Red Rooster Pinot Gris');
        set_theme_mod('si_written_menu_drinks_section_1_item_3_description', 'Okanagan, Canada');
        set_theme_mod('si_written_menu_drinks_section_1_item_3_price', '11/15/35');
            
        set_theme_mod('si_written_menu_drinks_section_1_item_4_name', 'Gray Monk Pinot Blanc');
        set_theme_mod('si_written_menu_drinks_section_1_item_4_description', 'Okanagan, Canada');
        set_theme_mod('si_written_menu_drinks_section_1_item_4_price', '11/14/38');
            
        set_theme_mod('si_written_menu_drinks_section_1_item_5_name', 'Tinhorn Creek Gewurztraminer');
        set_theme_mod('si_written_menu_drinks_section_1_item_5_description', 'Okanagan, Canada');
        set_theme_mod('si_written_menu_drinks_section_1_item_5_price', '12/17/44');
        
        set_theme_mod('si_written_menu_drinks_section_1_item_6_name', 'Blasted Church Hatfield\'s Fuse Blend');
        set_theme_mod('si_written_menu_drinks_section_1_item_6_description', 'Okanagan, Canada');
        set_theme_mod('si_written_menu_drinks_section_1_item_6_price', '13/18/45');
        
        set_theme_mod('si_written_menu_drinks_section_1_item_7_name', 'Oyster Bay Sauvignon Blanc');
        set_theme_mod('si_written_menu_drinks_section_1_item_7_description', 'New Zealand');
        set_theme_mod('si_written_menu_drinks_section_1_item_7_price', '14/19/49');
        
        // Red Wine Subsection (after White Wine, matching root file)
        set_theme_mod('si_written_menu_drinks_section_1_item_8_name', 'Red');
        set_theme_mod('si_written_menu_drinks_section_1_item_8_description', 'Glass / Half Litre / Bottle');
        set_theme_mod('si_written_menu_drinks_section_1_item_8_price', '');
        set_theme_mod('si_written_menu_drinks_section_1_item_8_notes', 'subsection');
        
        set_theme_mod('si_written_menu_drinks_section_1_item_9_name', 'Peller Estate Cabernet Merlot');
        set_theme_mod('si_written_menu_drinks_section_1_item_9_description', 'Okanagan, Canada');
        set_theme_mod('si_written_menu_drinks_section_1_item_9_price', '9/12/32');
        
        set_theme_mod('si_written_menu_drinks_section_1_item_10_name', 'Masi Corvina Malbec');
        set_theme_mod('si_written_menu_drinks_section_1_item_10_description', 'Argentina');
        set_theme_mod('si_written_menu_drinks_section_1_item_10_price', '11/14/40');
        
        set_theme_mod('si_written_menu_drinks_section_1_item_11_name', 'Red Rooster Cabernet Merlot');
        set_theme_mod('si_written_menu_drinks_section_1_item_11_description', 'Okanagan, Canada');
        set_theme_mod('si_written_menu_drinks_section_1_item_11_price', '12/17/44');
        
        set_theme_mod('si_written_menu_drinks_section_1_item_12_name', 'Oyster Bay Merlot');
        set_theme_mod('si_written_menu_drinks_section_1_item_12_description', 'New Zealand');
        set_theme_mod('si_written_menu_drinks_section_1_item_12_price', '14/19/52');
        
        set_theme_mod('si_written_menu_drinks_section_1_item_13_name', 'Blasted Church Big Bang Theory Blend');
        set_theme_mod('si_written_menu_drinks_section_1_item_13_description', 'Okanagan, Canada');
        set_theme_mod('si_written_menu_drinks_section_1_item_13_price', '15/20/55');
        
        set_theme_mod('si_written_menu_drinks_section_1_item_14_name', 'Oyster Bay Pinot Noir');
        set_theme_mod('si_written_menu_drinks_section_1_item_14_description', 'New Zealand');
        set_theme_mod('si_written_menu_drinks_section_1_item_14_price', '15/20/55');
        
        // Rosé Wine Subsection
        set_theme_mod('si_written_menu_drinks_section_1_item_15_name', 'Rosé');
        set_theme_mod('si_written_menu_drinks_section_1_item_15_description', 'Glass / Half Litre / Bottle');
        set_theme_mod('si_written_menu_drinks_section_1_item_15_price', '');
        set_theme_mod('si_written_menu_drinks_section_1_item_15_notes', 'subsection');
        
        set_theme_mod('si_written_menu_drinks_section_1_item_16_name', 'Gray Monk Latitude 50');
        set_theme_mod('si_written_menu_drinks_section_1_item_16_description', 'Okanagan, Canada');
        set_theme_mod('si_written_menu_drinks_section_1_item_16_price', '11/14/38');
        
        set_theme_mod('si_written_menu_drinks_section_1_item_17_name', 'Dirty Laundry Hush');
        set_theme_mod('si_written_menu_drinks_section_1_item_17_description', 'Okanagan, Canada');
        set_theme_mod('si_written_menu_drinks_section_1_item_17_price', '13/18/45');
        
        // Bubbles Subsection
        set_theme_mod('si_written_menu_drinks_section_1_item_18_name', 'Bubbles');
        set_theme_mod('si_written_menu_drinks_section_1_item_18_description', 'Glass / Bottle');
        set_theme_mod('si_written_menu_drinks_section_1_item_18_price', '');
        set_theme_mod('si_written_menu_drinks_section_1_item_18_notes', 'subsection');
        
        set_theme_mod('si_written_menu_drinks_section_1_item_19_name', 'Masi Modello Prosecco DOC');
        set_theme_mod('si_written_menu_drinks_section_1_item_19_description', 'Veneto, Italy');
        set_theme_mod('si_written_menu_drinks_section_1_item_19_price', '11/39');
        
        // Continue with the rest of the sections following the same structure as the root file
        // Section 2: Cocktails
        set_theme_mod('si_written_menu_drinks_section_2_title', 'Cocktails');
        set_theme_mod('si_written_menu_drinks_section_2_description', '');
        
        // Classics Subsection
        set_theme_mod('si_written_menu_drinks_section_2_item_1_name', 'Classics');
        set_theme_mod('si_written_menu_drinks_section_2_item_1_description', '');
        set_theme_mod('si_written_menu_drinks_section_2_item_1_price', '');
        set_theme_mod('si_written_menu_drinks_section_2_item_1_notes', 'subsection');
        
        // Continue with the rest of the cocktails section
        // ... (add the remaining items following the root file structure)
        
        error_log('Set drinks menu defaults using hardcoded values');
    }
    
    error_log('si_set_drinks_menu_defaults function completed from inc directory');
}

// Also define the global $drinks_defaults array for backward compatibility
global $drinks_defaults;
$drinks_defaults = array(
    'si_written_menu_drinks_title' => 'DRINKS MENU',
    'si_written_menu_drinks_description' => '',
    
    // Wine Section
    'si_written_menu_drinks_section_1_title' => 'Wine',
    'si_written_menu_drinks_section_1_description' => '',
    
    // White Wine Subsection (first, matching root file)
    'si_written_menu_drinks_section_1_item_1_name' => 'White',
    'si_written_menu_drinks_section_1_item_1_description' => 'Glass / Half Litre / Bottle',
    'si_written_menu_drinks_section_1_item_1_price' => '',
    'si_written_menu_drinks_section_1_item_1_notes' => 'subsection',
    
    'si_written_menu_drinks_section_1_item_2_name' => 'Peller Estate Chardonnay',
    'si_written_menu_drinks_section_1_item_2_description' => 'Okanagan, Canada',
    'si_written_menu_drinks_section_1_item_2_price' => '9/12/32',
        
    'si_written_menu_drinks_section_1_item_3_name' => 'Red Rooster Pinot Gris',
    'si_written_menu_drinks_section_1_item_3_description' => 'Okanagan, Canada',
    'si_written_menu_drinks_section_1_item_3_price' => '11/15/35',
        
    'si_written_menu_drinks_section_1_item_4_name' => 'Gray Monk Pinot Blanc',
    'si_written_menu_drinks_section_1_item_4_description' => 'Okanagan, Canada',
    'si_written_menu_drinks_section_1_item_4_price' => '11/14/38',
        
    'si_written_menu_drinks_section_1_item_5_name' => 'Tinhorn Creek Gewurztraminer',
    'si_written_menu_drinks_section_1_item_5_description' => 'Okanagan, Canada',
    'si_written_menu_drinks_section_1_item_5_price' => '12/17/44',
    
    'si_written_menu_drinks_section_1_item_6_name' => 'Blasted Church Hatfield\'s Fuse Blend',
    'si_written_menu_drinks_section_1_item_6_description' => 'Okanagan, Canada',
    'si_written_menu_drinks_section_1_item_6_price' => '13/18/45',
    
    'si_written_menu_drinks_section_1_item_7_name' => 'Oyster Bay Sauvignon Blanc',
    'si_written_menu_drinks_section_1_item_7_description' => 'New Zealand',
    'si_written_menu_drinks_section_1_item_7_price' => '14/19/49',
    
    // Red Wine Subsection (after White Wine, matching root file)
    'si_written_menu_drinks_section_1_item_8_name' => 'Red',
    'si_written_menu_drinks_section_1_item_8_description' => 'Glass / Half Litre / Bottle',
    'si_written_menu_drinks_section_1_item_8_price' => '',
    'si_written_menu_drinks_section_1_item_8_notes' => 'subsection',
    
    // Continue with the rest of the items following the same structure as the root file
    // ... (add the remaining items following the root file structure)
); 