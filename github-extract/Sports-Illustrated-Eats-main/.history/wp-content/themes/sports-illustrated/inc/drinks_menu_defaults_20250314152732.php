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
    error_log('si_set_drinks_menu_defaults function called');
    
    // Menu title and description
    set_theme_mod('si_written_menu_drinks_title', 'Drinks Menu');
    set_theme_mod('si_written_menu_drinks_description', 'Enjoy our selection of handcrafted cocktails, fine wines, and local beers.');

    // Section 1: Wine
    set_theme_mod('si_written_menu_drinks_section_1_title', 'Wine');
    set_theme_mod('si_written_menu_drinks_section_1_description', 'Our carefully curated wine selection features both local and international options.');
    
    // Wine subsection: Red
    set_theme_mod('si_written_menu_drinks_section_1_item_1_name', 'Red Wine');
    set_theme_mod('si_written_menu_drinks_section_1_item_1_description', 'Bold and rich selections');
    set_theme_mod('si_written_menu_drinks_section_1_item_1_price', '');
    set_theme_mod('si_written_menu_drinks_section_1_item_1_notes', 'subsection');
    
    // Red Wine Items
    set_theme_mod('si_written_menu_drinks_section_1_item_2_name', 'Cabernet Sauvignon');
    set_theme_mod('si_written_menu_drinks_section_1_item_2_description', 'Full-bodied with notes of black currant and cedar');
    set_theme_mod('si_written_menu_drinks_section_1_item_2_price', '$12 / $45');
    set_theme_mod('si_written_menu_drinks_section_1_item_2_notes', 'Glass / Bottle');
    
    set_theme_mod('si_written_menu_drinks_section_1_item_3_name', 'Pinot Noir');
    set_theme_mod('si_written_menu_drinks_section_1_item_3_description', 'Medium-bodied with hints of cherry and spice');
    set_theme_mod('si_written_menu_drinks_section_1_item_3_price', '$11 / $42');
    set_theme_mod('si_written_menu_drinks_section_1_item_3_notes', 'Glass / Bottle');
    
    set_theme_mod('si_written_menu_drinks_section_1_item_4_name', 'Malbec');
    set_theme_mod('si_written_menu_drinks_section_1_item_4_description', 'Rich and velvety with dark fruit flavors');
    set_theme_mod('si_written_menu_drinks_section_1_item_4_price', '$10 / $38');
    set_theme_mod('si_written_menu_drinks_section_1_item_4_notes', 'Glass / Bottle');
    
    // Wine subsection: White
    set_theme_mod('si_written_menu_drinks_section_1_item_5_name', 'White Wine');
    set_theme_mod('si_written_menu_drinks_section_1_item_5_description', 'Crisp and refreshing selections');
    set_theme_mod('si_written_menu_drinks_section_1_item_5_price', '');
    set_theme_mod('si_written_menu_drinks_section_1_item_5_notes', 'subsection');
    
    // White Wine Items
    set_theme_mod('si_written_menu_drinks_section_1_item_6_name', 'Chardonnay');
    set_theme_mod('si_written_menu_drinks_section_1_item_6_description', 'Buttery with notes of vanilla and tropical fruit');
    set_theme_mod('si_written_menu_drinks_section_1_item_6_price', '$11 / $42');
    set_theme_mod('si_written_menu_drinks_section_1_item_6_notes', 'Glass / Bottle');
    
    set_theme_mod('si_written_menu_drinks_section_1_item_7_name', 'Sauvignon Blanc');
    set_theme_mod('si_written_menu_drinks_section_1_item_7_description', 'Bright and zesty with citrus and herbal notes');
    set_theme_mod('si_written_menu_drinks_section_1_item_7_price', '$10 / $38');
    set_theme_mod('si_written_menu_drinks_section_1_item_7_notes', 'Glass / Bottle');
    
    set_theme_mod('si_written_menu_drinks_section_1_item_8_name', 'Pinot Grigio');
    set_theme_mod('si_written_menu_drinks_section_1_item_8_description', 'Light and crisp with apple and pear flavors');
    set_theme_mod('si_written_menu_drinks_section_1_item_8_price', '$9 / $34');
    set_theme_mod('si_written_menu_drinks_section_1_item_8_notes', 'Glass / Bottle');
    
    // Wine subsection: Sparkling
    set_theme_mod('si_written_menu_drinks_section_1_item_9_name', 'Sparkling');
    set_theme_mod('si_written_menu_drinks_section_1_item_9_description', 'Celebratory bubbles');
    set_theme_mod('si_written_menu_drinks_section_1_item_9_price', '');
    set_theme_mod('si_written_menu_drinks_section_1_item_9_notes', 'subsection');
    
    // Sparkling Wine Items
    set_theme_mod('si_written_menu_drinks_section_1_item_10_name', 'Prosecco');
    set_theme_mod('si_written_menu_drinks_section_1_item_10_description', 'Light and fruity Italian sparkling wine');
    set_theme_mod('si_written_menu_drinks_section_1_item_10_price', '$10 / $38');
    set_theme_mod('si_written_menu_drinks_section_1_item_10_notes', 'Glass / Bottle');
    
    set_theme_mod('si_written_menu_drinks_section_1_item_11_name', 'Champagne');
    set_theme_mod('si_written_menu_drinks_section_1_item_11_description', 'Classic French bubbly with toasty notes');
    set_theme_mod('si_written_menu_drinks_section_1_item_11_price', '$15 / $65');
    set_theme_mod('si_written_menu_drinks_section_1_item_11_notes', 'Glass / Bottle');

    // Section 2: Cocktails
    set_theme_mod('si_written_menu_drinks_section_2_title', 'Cocktails');
    set_theme_mod('si_written_menu_drinks_section_2_description', 'Handcrafted cocktails made with premium spirits and fresh ingredients.');
    
    // Cocktails subsection: Signature
    set_theme_mod('si_written_menu_drinks_section_2_item_1_name', 'Signature Cocktails');
    set_theme_mod('si_written_menu_drinks_section_2_item_1_description', 'Our house specialties');
    set_theme_mod('si_written_menu_drinks_section_2_item_1_price', '');
    set_theme_mod('si_written_menu_drinks_section_2_item_1_notes', 'subsection');
    
    // Signature Cocktail Items
    set_theme_mod('si_written_menu_drinks_section_2_item_2_name', 'Sports Illustrated');
    set_theme_mod('si_written_menu_drinks_section_2_item_2_description', 'Our signature cocktail with bourbon, sweet vermouth, and bitters');
    set_theme_mod('si_written_menu_drinks_section_2_item_2_price', '$14');
    set_theme_mod('si_written_menu_drinks_section_2_item_2_notes', '');
    
    set_theme_mod('si_written_menu_drinks_section_2_item_3_name', 'MVP Margarita');
    set_theme_mod('si_written_menu_drinks_section_2_item_3_description', 'Premium tequila, fresh lime, agave nectar, and a salt rim');
    set_theme_mod('si_written_menu_drinks_section_2_item_3_price', '$13');
    set_theme_mod('si_written_menu_drinks_section_2_item_3_notes', '');
    
    set_theme_mod('si_written_menu_drinks_section_2_item_4_name', 'Slam Dunk');
    set_theme_mod('si_written_menu_drinks_section_2_item_4_description', 'Vodka, blue curaçao, lemonade, and a splash of sprite');
    set_theme_mod('si_written_menu_drinks_section_2_item_4_price', '$12');
    set_theme_mod('si_written_menu_drinks_section_2_item_4_notes', '');
    
    // Cocktails subsection: Classics
    set_theme_mod('si_written_menu_drinks_section_2_item_5_name', 'Classic Cocktails');
    set_theme_mod('si_written_menu_drinks_section_2_item_5_description', 'Timeless favorites');
    set_theme_mod('si_written_menu_drinks_section_2_item_5_price', '');
    set_theme_mod('si_written_menu_drinks_section_2_item_5_notes', 'subsection');
    
    // Classic Cocktail Items
    set_theme_mod('si_written_menu_drinks_section_2_item_6_name', 'Old Fashioned');
    set_theme_mod('si_written_menu_drinks_section_2_item_6_description', 'Bourbon, sugar, bitters, and an orange twist');
    set_theme_mod('si_written_menu_drinks_section_2_item_6_price', '$13');
    set_theme_mod('si_written_menu_drinks_section_2_item_6_notes', '');
    
    set_theme_mod('si_written_menu_drinks_section_2_item_7_name', 'Manhattan');
    set_theme_mod('si_written_menu_drinks_section_2_item_7_description', 'Rye whiskey, sweet vermouth, and bitters');
    set_theme_mod('si_written_menu_drinks_section_2_item_7_price', '$14');
    set_theme_mod('si_written_menu_drinks_section_2_item_7_notes', '');
    
    set_theme_mod('si_written_menu_drinks_section_2_item_8_name', 'Negroni');
    set_theme_mod('si_written_menu_drinks_section_2_item_8_description', 'Gin, Campari, and sweet vermouth');
    set_theme_mod('si_written_menu_drinks_section_2_item_8_price', '$12');
    set_theme_mod('si_written_menu_drinks_section_2_item_8_notes', '');

    // Section 3: Beer
    set_theme_mod('si_written_menu_drinks_section_3_title', 'Beer');
    set_theme_mod('si_written_menu_drinks_section_3_description', 'A selection of craft and domestic beers.');
    
    // Beer subsection: On Tap
    set_theme_mod('si_written_menu_drinks_section_3_item_1_name', 'On Tap');
    set_theme_mod('si_written_menu_drinks_section_3_item_1_description', 'Fresh draft selections');
    set_theme_mod('si_written_menu_drinks_section_3_item_1_price', '');
    set_theme_mod('si_written_menu_drinks_section_3_item_1_notes', 'subsection');
    
    // On Tap Beer Items
    set_theme_mod('si_written_menu_drinks_section_3_item_2_name', 'Local IPA');
    set_theme_mod('si_written_menu_drinks_section_3_item_2_description', 'Hoppy and citrusy India Pale Ale');
    set_theme_mod('si_written_menu_drinks_section_3_item_2_price', '$7');
    set_theme_mod('si_written_menu_drinks_section_3_item_2_notes', '16 oz');
    
    set_theme_mod('si_written_menu_drinks_section_3_item_3_name', 'Seasonal Lager');
    set_theme_mod('si_written_menu_drinks_section_3_item_3_description', 'Crisp and refreshing lager');
    set_theme_mod('si_written_menu_drinks_section_3_item_3_price', '$6');
    set_theme_mod('si_written_menu_drinks_section_3_item_3_notes', '16 oz');
    
    set_theme_mod('si_written_menu_drinks_section_3_item_4_name', 'Wheat Ale');
    set_theme_mod('si_written_menu_drinks_section_3_item_4_description', 'Smooth and light with hints of citrus');
    set_theme_mod('si_written_menu_drinks_section_3_item_4_price', '$6');
    set_theme_mod('si_written_menu_drinks_section_3_item_4_notes', '16 oz');
    
    // Beer subsection: Bottled
    set_theme_mod('si_written_menu_drinks_section_3_item_5_name', 'Bottled');
    set_theme_mod('si_written_menu_drinks_section_3_item_5_description', 'By the bottle');
    set_theme_mod('si_written_menu_drinks_section_3_item_5_price', '');
    set_theme_mod('si_written_menu_drinks_section_3_item_5_notes', 'subsection');
    
    // Bottled Beer Items
    set_theme_mod('si_written_menu_drinks_section_3_item_6_name', 'Domestic');
    set_theme_mod('si_written_menu_drinks_section_3_item_6_description', 'Bud Light, Coors Light, Miller Lite');
    set_theme_mod('si_written_menu_drinks_section_3_item_6_price', '$5');
    set_theme_mod('si_written_menu_drinks_section_3_item_6_notes', '12 oz');
    
    set_theme_mod('si_written_menu_drinks_section_3_item_7_name', 'Imported');
    set_theme_mod('si_written_menu_drinks_section_3_item_7_description', 'Corona, Heineken, Stella Artois');
    set_theme_mod('si_written_menu_drinks_section_3_item_7_price', '$6');
    set_theme_mod('si_written_menu_drinks_section_3_item_7_notes', '12 oz');
    
    set_theme_mod('si_written_menu_drinks_section_3_item_8_name', 'Craft Selection');
    set_theme_mod('si_written_menu_drinks_section_3_item_8_description', 'Rotating selection of local craft beers');
    set_theme_mod('si_written_menu_drinks_section_3_item_8_price', '$7');
    set_theme_mod('si_written_menu_drinks_section_3_item_8_notes', '12 oz');

    // Section 4: Non-Alcoholic
    set_theme_mod('si_written_menu_drinks_section_4_title', 'Non-Alcoholic');
    set_theme_mod('si_written_menu_drinks_section_4_description', 'Refreshing options for non-drinkers.');
    
    // Non-Alcoholic subsection: Mocktails
    set_theme_mod('si_written_menu_drinks_section_4_item_1_name', 'Mocktails');
    set_theme_mod('si_written_menu_drinks_section_4_item_1_description', 'Alcohol-free craft beverages');
    set_theme_mod('si_written_menu_drinks_section_4_item_1_price', '');
    set_theme_mod('si_written_menu_drinks_section_4_item_1_notes', 'subsection');
    
    // Mocktail Items
    set_theme_mod('si_written_menu_drinks_section_4_item_2_name', 'Virgin Mojito');
    set_theme_mod('si_written_menu_drinks_section_4_item_2_description', 'Muddled lime, mint, sugar, and soda water');
    set_theme_mod('si_written_menu_drinks_section_4_item_2_price', '$7');
    set_theme_mod('si_written_menu_drinks_section_4_item_2_notes', '');
    
    set_theme_mod('si_written_menu_drinks_section_4_item_3_name', 'Cucumber Cooler');
    set_theme_mod('si_written_menu_drinks_section_4_item_3_description', 'Fresh cucumber, lime juice, mint, and soda');
    set_theme_mod('si_written_menu_drinks_section_4_item_3_price', '$7');
    set_theme_mod('si_written_menu_drinks_section_4_item_3_notes', '');
    
    set_theme_mod('si_written_menu_drinks_section_4_item_4_name', 'Berry Blast');
    set_theme_mod('si_written_menu_drinks_section_4_item_4_description', 'Mixed berries, lemon juice, and sparkling water');
    set_theme_mod('si_written_menu_drinks_section_4_item_4_price', '$8');
    set_theme_mod('si_written_menu_drinks_section_4_item_4_notes', '');
    
    // Non-Alcoholic subsection: Soft Drinks
    set_theme_mod('si_written_menu_drinks_section_4_item_5_name', 'Soft Drinks & More');
    set_theme_mod('si_written_menu_drinks_section_4_item_5_description', 'Classic refreshments');
    set_theme_mod('si_written_menu_drinks_section_4_item_5_price', '');
    set_theme_mod('si_written_menu_drinks_section_4_item_5_notes', 'subsection');
    
    // Soft Drinks Items
    set_theme_mod('si_written_menu_drinks_section_4_item_6_name', 'Soda');
    set_theme_mod('si_written_menu_drinks_section_4_item_6_description', 'Coke, Diet Coke, Sprite, Ginger Ale');
    set_theme_mod('si_written_menu_drinks_section_4_item_6_price', '$3');
    set_theme_mod('si_written_menu_drinks_section_4_item_6_notes', 'Free refills');
    
    set_theme_mod('si_written_menu_drinks_section_4_item_7_name', 'Iced Tea');
    set_theme_mod('si_written_menu_drinks_section_4_item_7_description', 'Freshly brewed, sweetened or unsweetened');
    set_theme_mod('si_written_menu_drinks_section_4_item_7_price', '$3');
    set_theme_mod('si_written_menu_drinks_section_4_item_7_notes', 'Free refills');
    
    set_theme_mod('si_written_menu_drinks_section_4_item_8_name', 'Coffee');
    set_theme_mod('si_written_menu_drinks_section_4_item_8_description', 'Regular or decaf');
    set_theme_mod('si_written_menu_drinks_section_4_item_8_price', '$3');
    set_theme_mod('si_written_menu_drinks_section_4_item_8_notes', 'Free refills');
    
    error_log('si_set_drinks_menu_defaults function completed');
}

// Also define the global $drinks_defaults array for backward compatibility
global $drinks_defaults;
$drinks_defaults = array(
    'si_written_menu_drinks_title' => 'Drinks Menu',
    'si_written_menu_drinks_description' => 'Enjoy our selection of handcrafted cocktails, fine wines, and local beers.',
    
    // Section 1: Wine
    'si_written_menu_drinks_section_1_title' => 'Wine',
    'si_written_menu_drinks_section_1_description' => 'Our carefully curated wine selection features both local and international options.',
    
    // Wine subsection: Red
    'si_written_menu_drinks_section_1_item_1_name' => 'Red Wine',
    'si_written_menu_drinks_section_1_item_1_description' => 'Bold and rich selections',
    'si_written_menu_drinks_section_1_item_1_price' => '',
    'si_written_menu_drinks_section_1_item_1_notes' => 'subsection',
    
    // Red Wine Items
    'si_written_menu_drinks_section_1_item_2_name' => 'Cabernet Sauvignon',
    'si_written_menu_drinks_section_1_item_2_description' => 'Full-bodied with notes of black currant and cedar',
    'si_written_menu_drinks_section_1_item_2_price' => '$12 / $45',
    'si_written_menu_drinks_section_1_item_2_notes' => 'Glass / Bottle',
    
    // ... add more items as needed
); 