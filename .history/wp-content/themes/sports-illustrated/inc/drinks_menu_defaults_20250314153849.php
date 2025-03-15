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
    
       // White Wine Subsection
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
       
       // Red Wine Subsection
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
       
       // Cocktails Section
       set_theme_mod('si_written_menu_drinks_section_2_title', 'Cocktails');
       set_theme_mod('si_written_menu_drinks_section_2_description', '');
       
       // Classics Subsection
       set_theme_mod('si_written_menu_drinks_section_2_item_1_name', 'Classics');
       set_theme_mod('si_written_menu_drinks_section_2_item_1_description', '');
       set_theme_mod('si_written_menu_drinks_section_2_item_1_price', '');
       set_theme_mod('si_written_menu_drinks_section_2_item_1_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_2_name', 'Shaft');
       set_theme_mod('si_written_menu_drinks_section_2_item_2_description', 'Vodka, Bailey\'s, Kahlua, cold brew coffee');
       set_theme_mod('si_written_menu_drinks_section_2_item_2_price', '8');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_3_name', 'Aperol Spritz');
       set_theme_mod('si_written_menu_drinks_section_2_item_3_description', 'Aperol, prosecco, topped with club soda');
       set_theme_mod('si_written_menu_drinks_section_2_item_3_price', '12');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_4_name', 'Ranch Water');
       set_theme_mod('si_written_menu_drinks_section_2_item_4_description', 'Tequila blanco, lime juice, topped with sparkling water');
       set_theme_mod('si_written_menu_drinks_section_2_item_4_price', '12');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_5_name', 'Moscow Mule');
       set_theme_mod('si_written_menu_drinks_section_2_item_5_description', 'Ketel One vodka, lime juice, topped with ginger beer');
       set_theme_mod('si_written_menu_drinks_section_2_item_5_price', '12.5');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_6_name', 'Gin Basil Smash');
       set_theme_mod('si_written_menu_drinks_section_2_item_6_description', 'Empress elderflower rose gin, basil, lime juice, simple syrup');
       set_theme_mod('si_written_menu_drinks_section_2_item_6_price', '13');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_7_name', 'Negroni');
       set_theme_mod('si_written_menu_drinks_section_2_item_7_description', 'Gin, Campari, sweet vermouth');
       set_theme_mod('si_written_menu_drinks_section_2_item_7_price', '14');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_8_name', 'Old Fashioned');
       set_theme_mod('si_written_menu_drinks_section_2_item_8_description', 'Buffalo Trace, orange bitters');
       set_theme_mod('si_written_menu_drinks_section_2_item_8_price', '14.5');
       
       // Signature Cocktails Subsection
       set_theme_mod('si_written_menu_drinks_section_2_item_9_name', 'Signature');
       set_theme_mod('si_written_menu_drinks_section_2_item_9_description', '');
       set_theme_mod('si_written_menu_drinks_section_2_item_9_price', '');
       set_theme_mod('si_written_menu_drinks_section_2_item_9_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_10_name', 'Espresso Martini');
       set_theme_mod('si_written_menu_drinks_section_2_item_10_description', 'Vodka, Kahlua, Bailey\'s, cold brew coffee, cream, toasted marshmallow');
       set_theme_mod('si_written_menu_drinks_section_2_item_10_price', '14');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_11_name', 'Spicy Mango Margarita');
       set_theme_mod('si_written_menu_drinks_section_2_item_11_description', 'Blanco tequila, triple sec, passionfruit juice, mango purée, jalapeño chili syrup');
       set_theme_mod('si_written_menu_drinks_section_2_item_11_price', '13');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_12_name', 'Caribbean Ripple');
       set_theme_mod('si_written_menu_drinks_section_2_item_12_description', 'White rum, butter ripple, pineapple juice');
       set_theme_mod('si_written_menu_drinks_section_2_item_12_price', '13');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_13_name', 'Sex on the Peach');
       set_theme_mod('si_written_menu_drinks_section_2_item_13_description', 'Vodka, peach schnapps, peach syrup, lemon juice, fuzzy peach garnish');
       set_theme_mod('si_written_menu_drinks_section_2_item_13_price', '13');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_14_name', 'Rose Gin Sour');
       set_theme_mod('si_written_menu_drinks_section_2_item_14_description', 'Empress rose gin, St. Germaine, elderflower, lemon juice, rosemary syrup');
       set_theme_mod('si_written_menu_drinks_section_2_item_14_price', '14');
       
       set_theme_mod('si_written_menu_drinks_section_2_item_15_name', 'Empress Gin Bloom');
       set_theme_mod('si_written_menu_drinks_section_2_item_15_description', 'Empress gin, rosemary syrup, Fentiman\'s grapefruit tonic water');
       set_theme_mod('si_written_menu_drinks_section_2_item_15_price', '14');
       
       // On Tap Section
       set_theme_mod('si_written_menu_drinks_section_3_title', 'On Tap');
       set_theme_mod('si_written_menu_drinks_section_3_description', '');
       
       // Domestic Beers Subsection
       set_theme_mod('si_written_menu_drinks_section_3_item_1_name', 'Domestic');
       set_theme_mod('si_written_menu_drinks_section_3_item_1_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_1_price', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_1_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_2_name', 'Thunder Beer Lager');
       set_theme_mod('si_written_menu_drinks_section_3_item_2_description', 'White Rock Beach');
       set_theme_mod('si_written_menu_drinks_section_3_item_2_price', '5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_3_name', 'Landshark Lager');
       set_theme_mod('si_written_menu_drinks_section_3_item_3_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_3_price', '4.6% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_4_name', 'Tilt Lager');
       set_theme_mod('si_written_menu_drinks_section_3_item_4_description', 'Phillips');
       set_theme_mod('si_written_menu_drinks_section_3_item_4_price', '5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_5_name', 'Premium Lager Series');
       set_theme_mod('si_written_menu_drinks_section_3_item_5_description', 'Barnside');
       set_theme_mod('si_written_menu_drinks_section_3_item_5_price', '5.4% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_6_name', 'Salted Lime Lager');
       set_theme_mod('si_written_menu_drinks_section_3_item_6_description', 'La Cervecería Astilleros');
       set_theme_mod('si_written_menu_drinks_section_3_item_6_price', '4.6% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_7_name', 'Pineapple Pilsner');
       set_theme_mod('si_written_menu_drinks_section_3_item_7_description', 'Storm');
       set_theme_mod('si_written_menu_drinks_section_3_item_7_price', '5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_8_name', 'Fat Tug IPA');
       set_theme_mod('si_written_menu_drinks_section_3_item_8_description', 'Driftwood');
       set_theme_mod('si_written_menu_drinks_section_3_item_8_price', '7% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_9_name', 'Humans Hazy IPA');
       set_theme_mod('si_written_menu_drinks_section_3_item_9_description', 'Parkside');
       set_theme_mod('si_written_menu_drinks_section_3_item_9_price', '6.3% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_10_name', 'Play Dead IPA');
       set_theme_mod('si_written_menu_drinks_section_3_item_10_description', 'Yellowdog');
       set_theme_mod('si_written_menu_drinks_section_3_item_10_price', '6.8% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_11_name', 'Space Kitty Juicy IPA');
       set_theme_mod('si_written_menu_drinks_section_3_item_11_description', 'Parallel 49');
       set_theme_mod('si_written_menu_drinks_section_3_item_11_price', '6.5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_12_name', 'Raspberry Wheat Ale');
       set_theme_mod('si_written_menu_drinks_section_3_item_12_description', 'Twin Sails');
       set_theme_mod('si_written_menu_drinks_section_3_item_12_price', '5.1% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_13_name', 'Blue Moon');
       set_theme_mod('si_written_menu_drinks_section_3_item_13_description', 'Belgian White');
       set_theme_mod('si_written_menu_drinks_section_3_item_13_price', '5.4% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_14_name', 'Jongleur Wit');
       set_theme_mod('si_written_menu_drinks_section_3_item_14_description', 'Strange Fellows');
       set_theme_mod('si_written_menu_drinks_section_3_item_14_price', '4.5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_15_name', 'Blue Buck Ale');
       set_theme_mod('si_written_menu_drinks_section_3_item_15_description', 'Phillips');
       set_theme_mod('si_written_menu_drinks_section_3_item_15_price', '5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_16_name', 'Glitter Bomb Hazy Pale Ale');
       set_theme_mod('si_written_menu_drinks_section_3_item_16_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_16_price', '5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_17_name', 'Citra Pale Ale');
       set_theme_mod('si_written_menu_drinks_section_3_item_17_description', 'Twin Sails');
       set_theme_mod('si_written_menu_drinks_section_3_item_17_price', '5.2% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_18_name', 'Talisman');
       set_theme_mod('si_written_menu_drinks_section_3_item_18_description', 'Strange Fellows');
       set_theme_mod('si_written_menu_drinks_section_3_item_18_price', '4% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_19_name', 'Rotating Cider');
       set_theme_mod('si_written_menu_drinks_section_3_item_19_description', 'Brickers GF');
       set_theme_mod('si_written_menu_drinks_section_3_item_19_price', '5.4% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_20_name', 'Dinosaur');
       set_theme_mod('si_written_menu_drinks_section_3_item_20_description', 'Phillips');
       set_theme_mod('si_written_menu_drinks_section_3_item_20_price', '4.2% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_21_name', 'Hula Hula Tropical Sour');
       set_theme_mod('si_written_menu_drinks_section_3_item_21_description', 'Main Street Brewing');
       set_theme_mod('si_written_menu_drinks_section_3_item_21_price', '3.5% | 8.5 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_22_name', 'Back Hand of God');
       set_theme_mod('si_written_menu_drinks_section_3_item_22_description', 'Crannog');
       set_theme_mod('si_written_menu_drinks_section_3_item_22_price', '5.2% | 9 / 25');
       
       // Import Beers Subsection
       set_theme_mod('si_written_menu_drinks_section_3_item_23_name', 'Import');
       set_theme_mod('si_written_menu_drinks_section_3_item_23_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_23_price', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_23_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_24_name', 'Stella Artois');
       set_theme_mod('si_written_menu_drinks_section_3_item_24_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_24_price', '5.2% | 11');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_25_name', 'Carlsberg Pilsner');
       set_theme_mod('si_written_menu_drinks_section_3_item_25_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_25_price', '5% | 11');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_26_name', 'Kronenbourg Blanc');
       set_theme_mod('si_written_menu_drinks_section_3_item_26_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_26_price', '5% | 11');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_27_name', 'Guinness');
       set_theme_mod('si_written_menu_drinks_section_3_item_27_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_27_price', '4.2% | 11');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_28_name', 'Sommersby LC');
       set_theme_mod('si_written_menu_drinks_section_3_item_28_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_28_price', '4.5% | 11');
       
       // Cocktails on Tap Subsection
       set_theme_mod('si_written_menu_drinks_section_3_item_29_name', 'Cocktails On Tap');
       set_theme_mod('si_written_menu_drinks_section_3_item_29_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_29_price', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_29_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_30_name', 'Please! Margarita');
       set_theme_mod('si_written_menu_drinks_section_3_item_30_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_30_price', '12.5');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_31_name', 'Please! Raspberry Mint');
       set_theme_mod('si_written_menu_drinks_section_3_item_31_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_31_price', '12.5');
       
       // Off Tap Section
       set_theme_mod('si_written_menu_drinks_section_4_title', 'Off Tap');
       set_theme_mod('si_written_menu_drinks_section_4_description', '');
           
       // Seltzer Subsection
       set_theme_mod('si_written_menu_drinks_section_4_item_1_name', 'Seltzer');
       set_theme_mod('si_written_menu_drinks_section_4_item_1_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_1_price', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_1_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_2_name', 'Happy Dad');
       set_theme_mod('si_written_menu_drinks_section_4_item_2_description', 'Assorted Flavours');
       set_theme_mod('si_written_menu_drinks_section_4_item_2_price', '5% | 8');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_3_name', 'The Long Drink');
       set_theme_mod('si_written_menu_drinks_section_4_item_3_description', 'Original or Sugar-Free');
       set_theme_mod('si_written_menu_drinks_section_4_item_3_price', '5% | 6');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_4_name', 'White Claw');
       set_theme_mod('si_written_menu_drinks_section_4_item_4_description', 'Lime, Black Cherry, Mango');
       set_theme_mod('si_written_menu_drinks_section_4_item_4_price', '5% | 6');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_5_name', 'No Boats on Sunday');
       set_theme_mod('si_written_menu_drinks_section_4_item_5_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_5_price', '5% | 8');
       
       // Bottles Subsection
       set_theme_mod('si_written_menu_drinks_section_4_item_6_name', 'Bottles');
       set_theme_mod('si_written_menu_drinks_section_4_item_6_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_6_price', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_6_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_7_name', 'Bud Light (330ml)');
       set_theme_mod('si_written_menu_drinks_section_4_item_7_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_7_price', '4.2% | 5.5');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_8_name', 'Kokanee (330ml)');
       set_theme_mod('si_written_menu_drinks_section_4_item_8_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_8_price', '5% | 5.5');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_9_name', 'Canadian (330ml)');
       set_theme_mod('si_written_menu_drinks_section_4_item_9_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_9_price', '5% | 5.5');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_10_name', 'Corona (330ml)');
       set_theme_mod('si_written_menu_drinks_section_4_item_10_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_10_price', '4.6% | 6.5');
       
       // Cans Subsection
       set_theme_mod('si_written_menu_drinks_section_4_item_11_name', 'Cans');
       set_theme_mod('si_written_menu_drinks_section_4_item_11_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_11_price', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_11_notes', 'subsection');
       set_theme_mod('si_written_menu_drinks_section_4_item_12_name', 'Thunder Beer Lager (355ml)');
       set_theme_mod('si_written_menu_drinks_section_4_item_12_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_12_price', '5% | 5');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_13_name', 'Glutenberg Blonde (473ml) GF');
       set_theme_mod('si_written_menu_drinks_section_4_item_13_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_13_price', '4.5% | 8');
       
       // Non-Alcoholic Drinks Subsection
       set_theme_mod('si_written_menu_drinks_section_4_item_14_name', 'Non-alcoholic');
       set_theme_mod('si_written_menu_drinks_section_4_item_14_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_2_name', 'Shaft');
       set_theme_mod('si_written_menu_drinks_section_3_item_2_description', 'Vodka, Bailey\'s, Kahlua, cold brew coffee');
       set_theme_mod('si_written_menu_drinks_section_3_item_2_price', '8');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_3_name', 'Aperol Spritz');
       set_theme_mod('si_written_menu_drinks_section_3_item_3_description', 'Aperol, prosecco, topped with club soda');
       set_theme_mod('si_written_menu_drinks_section_3_item_3_price', '12');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_4_name', 'Ranch Water');
       set_theme_mod('si_written_menu_drinks_section_3_item_4_description', 'Tequila blanco, lime juice, topped with sparkling water');
       set_theme_mod('si_written_menu_drinks_section_3_item_4_price', '12');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_5_name', 'Moscow Mule');
       set_theme_mod('si_written_menu_drinks_section_3_item_5_description', 'Ketel One vodka, lime juice, topped with ginger beer');
       set_theme_mod('si_written_menu_drinks_section_3_item_5_price', '12.5');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_6_name', 'Gin Basil Smash');
       set_theme_mod('si_written_menu_drinks_section_3_item_6_description', 'Empress elderflower rose gin, basil, lime juice, simple syrup');
       set_theme_mod('si_written_menu_drinks_section_3_item_6_price', '13');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_7_name', 'Negroni');
       set_theme_mod('si_written_menu_drinks_section_3_item_7_description', 'Gin, Campari, sweet vermouth');
       set_theme_mod('si_written_menu_drinks_section_3_item_7_price', '14');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_8_name', 'Old Fashioned');
       set_theme_mod('si_written_menu_drinks_section_3_item_8_description', 'Buffalo Trace, orange bitters');
       set_theme_mod('si_written_menu_drinks_section_3_item_8_price', '14.5');
       
       // Signature Cocktails Subsection
       set_theme_mod('si_written_menu_drinks_section_3_item_9_name', 'Signature Cocktails');
       set_theme_mod('si_written_menu_drinks_section_3_item_9_description', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_9_price', '');
       set_theme_mod('si_written_menu_drinks_section_3_item_9_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_10_name', 'Espresso Martini');
       set_theme_mod('si_written_menu_drinks_section_3_item_10_description', 'Vodka, Kahlua, Bailey\'s, cold brew coffee, cream, toasted marshmallow');
       set_theme_mod('si_written_menu_drinks_section_3_item_10_price', '14');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_11_name', 'Spicy Mango Margarita');
       set_theme_mod('si_written_menu_drinks_section_3_item_11_description', 'Blanco tequila, triple sec, passionfruit juice, mango purée, jalapeño chili syrup');
       set_theme_mod('si_written_menu_drinks_section_3_item_11_price', '13');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_12_name', 'Caribbean Ripple');
       set_theme_mod('si_written_menu_drinks_section_3_item_12_description', 'White rum, butter ripple, pineapple juice');
       set_theme_mod('si_written_menu_drinks_section_3_item_12_price', '13');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_13_name', 'Sex on the Peach');
       set_theme_mod('si_written_menu_drinks_section_3_item_13_description', 'Vodka, peach schnapps, peach syrup, lemon juice, fuzzy peach garnish');
       set_theme_mod('si_written_menu_drinks_section_3_item_13_price', '13');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_14_name', 'Rose Gin Sour');
       set_theme_mod('si_written_menu_drinks_section_3_item_14_description', 'Empress rose gin, St. Germaine, elderflower, lemon juice, rosemary syrup');
       set_theme_mod('si_written_menu_drinks_section_3_item_14_price', '14');
       
       set_theme_mod('si_written_menu_drinks_section_3_item_15_name', 'Empress Gin Bloom');
       set_theme_mod('si_written_menu_drinks_section_3_item_15_description', 'Empress gin, rosemary syrup, Fentiman\'s grapefruit tonic water');
       set_theme_mod('si_written_menu_drinks_section_3_item_15_price', '14');
       
       // On Tap Section
       set_theme_mod('si_written_menu_drinks_section_4_title', 'On Tap');
       set_theme_mod('si_written_menu_drinks_section_4_description', '');
       
       // Domestic Beers Subsection
       set_theme_mod('si_written_menu_drinks_section_4_item_1_name', 'Domestic Beers');
       set_theme_mod('si_written_menu_drinks_section_4_item_1_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_1_price', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_1_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_2_name', 'Thunder Beer Lager');
       set_theme_mod('si_written_menu_drinks_section_4_item_2_description', 'White Rock Beach');
       set_theme_mod('si_written_menu_drinks_section_4_item_2_price', '5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_3_name', 'Landshark Lager');
       set_theme_mod('si_written_menu_drinks_section_4_item_3_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_3_price', '4.6% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_4_name', 'Tilt Lager');
       set_theme_mod('si_written_menu_drinks_section_4_item_4_description', 'Phillips');
       set_theme_mod('si_written_menu_drinks_section_4_item_4_price', '5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_5_name', 'Premium Lager Series');
       set_theme_mod('si_written_menu_drinks_section_4_item_5_description', 'Barnside');
       set_theme_mod('si_written_menu_drinks_section_4_item_5_price', '5.4% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_6_name', 'Salted Lime Lager');
       set_theme_mod('si_written_menu_drinks_section_4_item_6_description', 'La Cervecería Astilleros');
       set_theme_mod('si_written_menu_drinks_section_4_item_6_price', '4.6% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_7_name', 'Pineapple Pilsner');
       set_theme_mod('si_written_menu_drinks_section_4_item_7_description', 'Storm');
       set_theme_mod('si_written_menu_drinks_section_4_item_7_price', '5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_8_name', 'Fat Tug IPA');
       set_theme_mod('si_written_menu_drinks_section_4_item_8_description', 'Driftwood');
       set_theme_mod('si_written_menu_drinks_section_4_item_8_price', '7% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_9_name', 'Humans Hazy IPA');
       set_theme_mod('si_written_menu_drinks_section_4_item_9_description', 'Parkside');
       set_theme_mod('si_written_menu_drinks_section_4_item_9_price', '6.3% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_10_name', 'Play Dead IPA');
       set_theme_mod('si_written_menu_drinks_section_4_item_10_description', 'Yellowdog');
       set_theme_mod('si_written_menu_drinks_section_4_item_10_price', '6.8% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_11_name', 'Space Kitty Juicy IPA');
       set_theme_mod('si_written_menu_drinks_section_4_item_11_description', 'Parallel 49');
       set_theme_mod('si_written_menu_drinks_section_4_item_11_price', '6.5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_12_name', 'Raspberry Wheat Ale');
       set_theme_mod('si_written_menu_drinks_section_4_item_12_description', 'Twin Sails');
       set_theme_mod('si_written_menu_drinks_section_4_item_12_price', '5.1% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_13_name', 'Blue Moon');
       set_theme_mod('si_written_menu_drinks_section_4_item_13_description', 'Belgian White');
       set_theme_mod('si_written_menu_drinks_section_4_item_13_price', '5.4% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_14_name', 'Jongleur Wit');
       set_theme_mod('si_written_menu_drinks_section_4_item_14_description', 'Strange Fellows');
       set_theme_mod('si_written_menu_drinks_section_4_item_14_price', '4.5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_15_name', 'Blue Buck Ale');
       set_theme_mod('si_written_menu_drinks_section_4_item_15_description', 'Phillips');
       set_theme_mod('si_written_menu_drinks_section_4_item_15_price', '5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_16_name', 'Glitter Bomb Hazy Pale Ale');
       set_theme_mod('si_written_menu_drinks_section_4_item_16_description', '');
       set_theme_mod('si_written_menu_drinks_section_4_item_16_price', '5% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_17_name', 'Citra Pale Ale');
       set_theme_mod('si_written_menu_drinks_section_4_item_17_description', 'Twin Sails');
       set_theme_mod('si_written_menu_drinks_section_4_item_17_price', '5.2% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_18_name', 'Talisman');
       set_theme_mod('si_written_menu_drinks_section_4_item_18_description', 'Strange Fellows');
       set_theme_mod('si_written_menu_drinks_section_4_item_18_price', '4% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_19_name', 'Rotating Cider');
       set_theme_mod('si_written_menu_drinks_section_4_item_19_description', 'Brickers GF');
       set_theme_mod('si_written_menu_drinks_section_4_item_19_price', '5.4% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_20_name', 'Dinosaur');
       set_theme_mod('si_written_menu_drinks_section_4_item_20_description', 'Phillips');
       set_theme_mod('si_written_menu_drinks_section_4_item_20_price', '4.2% | 8 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_21_name', 'Hula Hula Tropical Sour');
       set_theme_mod('si_written_menu_drinks_section_4_item_21_description', 'Main Street Brewing');
       set_theme_mod('si_written_menu_drinks_section_4_item_21_price', '3.5% | 8.5 / 25');
       
       set_theme_mod('si_written_menu_drinks_section_4_item_22_name', 'Back Hand of God');
       set_theme_mod('si_written_menu_drinks_section_4_item_22_description', 'Crannog');
       set_theme_mod('si_written_menu_drinks_section_4_item_22_price', '5.2% | 9 / 25');
       
       // Imported Beers Subsection
       set_theme_mod('si_written_menu_drinks_section_5_title', 'Imported Beers');
       set_theme_mod('si_written_menu_drinks_section_5_description', '');
       
       set_theme_mod('si_written_menu_drinks_section_5_item_1_name', 'Stella Artois');
       set_theme_mod('si_written_menu_drinks_section_5_item_1_description', '');
       set_theme_mod('si_written_menu_drinks_section_5_item_1_price', '5.2% | 11');
       
       set_theme_mod('si_written_menu_drinks_section_5_item_2_name', 'Carlsberg Pilsner');
       set_theme_mod('si_written_menu_drinks_section_5_item_2_description', '');
       set_theme_mod('si_written_menu_drinks_section_5_item_2_price', '5% | 11');
       
       set_theme_mod('si_written_menu_drinks_section_5_item_3_name', 'Kronenbourg Blanc');
       set_theme_mod('si_written_menu_drinks_section_5_item_3_description', '');
       set_theme_mod('si_written_menu_drinks_section_5_item_3_price', '5% | 11');
       
       set_theme_mod('si_written_menu_drinks_section_5_item_4_name', 'Guinness');
       set_theme_mod('si_written_menu_drinks_section_5_item_4_description', '');
       set_theme_mod('si_written_menu_drinks_section_5_item_4_price', '4.2% | 11');
       
       set_theme_mod('si_written_menu_drinks_section_5_item_5_name', 'Sommersby LC');
       set_theme_mod('si_written_menu_drinks_section_5_item_5_description', '');
       set_theme_mod('si_written_menu_drinks_section_5_item_5_price', '4.5% | 11');
       
       // Cocktails on Tap Subsection
       set_theme_mod('si_written_menu_drinks_section_5_item_6_name', 'Cocktails on Tap');
       set_theme_mod('si_written_menu_drinks_section_5_item_6_description', '');
       set_theme_mod('si_written_menu_drinks_section_5_item_6_price', '');
       set_theme_mod('si_written_menu_drinks_section_5_item_6_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_5_item_7_name', 'Please! Margarita');
       set_theme_mod('si_written_menu_drinks_section_5_item_7_description', '');
       set_theme_mod('si_written_menu_drinks_section_5_item_7_price', '12.5');
       
       set_theme_mod('si_written_menu_drinks_section_5_item_8_name', 'Please! Raspberry Mint');
       set_theme_mod('si_written_menu_drinks_section_5_item_8_description', '');
       set_theme_mod('si_written_menu_drinks_section_5_item_8_price', '12.5');
       
       // Off Tap Section
       set_theme_mod('si_written_menu_drinks_section_6_title', 'Off Tap');
       set_theme_mod('si_written_menu_drinks_section_6_description', '');
       
       // Seltzer Subsection
       set_theme_mod('si_written_menu_drinks_section_6_item_1_name', 'Seltzer');
       set_theme_mod('si_written_menu_drinks_section_6_item_1_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_1_price', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_1_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_2_name', 'Happy Dad');
       set_theme_mod('si_written_menu_drinks_section_6_item_2_description', 'Assorted Flavours');
       set_theme_mod('si_written_menu_drinks_section_6_item_2_price', '5% | 8');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_3_name', 'The Long Drink');
       set_theme_mod('si_written_menu_drinks_section_6_item_3_description', 'Original or Sugar-Free');
       set_theme_mod('si_written_menu_drinks_section_6_item_3_price', '5% | 6');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_4_name', 'White Claw');
       set_theme_mod('si_written_menu_drinks_section_6_item_4_description', 'Lime, Black Cherry, Mango');
       set_theme_mod('si_written_menu_drinks_section_6_item_4_price', '5% | 6');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_5_name', 'No Boats on Sunday');
       set_theme_mod('si_written_menu_drinks_section_6_item_5_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_5_price', '5% | 8');
       
       // Bottles Subsection
       set_theme_mod('si_written_menu_drinks_section_6_item_6_name', 'Bottles');
       set_theme_mod('si_written_menu_drinks_section_6_item_6_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_6_price', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_6_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_7_name', 'Bud Light (330ml)');
       set_theme_mod('si_written_menu_drinks_section_6_item_7_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_7_price', '4.2% | 5.5');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_8_name', 'Kokanee (330ml)');
       set_theme_mod('si_written_menu_drinks_section_6_item_8_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_8_price', '5% | 5.5');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_9_name', 'Canadian (330ml)');
       set_theme_mod('si_written_menu_drinks_section_6_item_9_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_9_price', '5% | 5.5');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_10_name', 'Corona (330ml)');
       set_theme_mod('si_written_menu_drinks_section_6_item_10_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_10_price', '4.6% | 6.5');
       
       // Cans Subsection
       set_theme_mod('si_written_menu_drinks_section_6_item_11_name', 'Cans');
       set_theme_mod('si_written_menu_drinks_section_6_item_11_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_11_price', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_11_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_12_name', 'Thunder Beer Lager (355ml)');
       set_theme_mod('si_written_menu_drinks_section_6_item_12_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_12_price', '5% | 5');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_13_name', 'Glutenberg Blonde (473ml) GF');
       set_theme_mod('si_written_menu_drinks_section_6_item_13_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_13_price', '4.5% | 8');
       
       // Non-Alcoholic Drinks Subsection
       set_theme_mod('si_written_menu_drinks_section_6_item_14_name', 'Non-Alcoholic Drinks');
       set_theme_mod('si_written_menu_drinks_section_6_item_14_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_14_price', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_14_notes', 'subsection');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_15_name', 'Corona Sunbrew (330ml)');
       set_theme_mod('si_written_menu_drinks_section_6_item_15_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_15_price', '5');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_16_name', 'Heineken 0.0');
       set_theme_mod('si_written_menu_drinks_section_6_item_16_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_16_price', '5');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_17_name', 'Fentiman\'s Ginger Beer');
       set_theme_mod('si_written_menu_drinks_section_6_item_17_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_17_price', '6');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_18_name', 'Fentiman\'s Rose Lemonade');
       set_theme_mod('si_written_menu_drinks_section_6_item_18_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_18_price', '6');
       
       set_theme_mod('si_written_menu_drinks_section_6_item_19_name', 'Red Bull Can');
       set_theme_mod('si_written_menu_drinks_section_6_item_19_description', '');
       set_theme_mod('si_written_menu_drinks_section_6_item_19_price', '7');
       
       // Mocktails Subsection
       set_theme_mod('si_written_menu_drinks_section_7_title', 'Mocktails');
       set_theme_mod('si_written_menu_drinks_section_7_description', '');
       
       set_theme_mod('si_written_menu_drinks_section_7_item_1_name', 'Virgin Caesar');
       set_theme_mod('si_written_menu_drinks_section_7_item_1_description', 'Clamato juice, Tabasco, Worcestershire sauce, pickled bean');
       set_theme_mod('si_written_menu_drinks_section_7_item_1_price', '6');
       
       set_theme_mod('si_written_menu_drinks_section_7_item_2_name', 'Virgin Mojito');
       set_theme_mod('si_written_menu_drinks_section_7_item_2_description', 'Fresh squeezed lime, mint, soda');
       set_theme_mod('si_written_menu_drinks_section_7_item_2_price', '6');
       
       set_theme_mod('si_written_menu_drinks_section_7_item_3_name', 'Rosemary-Pomegranate Soda');
       set_theme_mod('si_written_menu_drinks_section_7_item_3_description', 'Pomegranate juice, rosemary simple syrup, soda');
       set_theme_mod('si_written_menu_drinks_section_7_item_3_price', '6');
       set_theme_mod('si_written_menu_drinks_section_7_item_4_name', 'Blueberry Mint Lemonade');
       set_theme_mod('si_written_menu_drinks_section_7_item_4_description', 'Blueberry syrup, mint, house-made lemonade');
       set_theme_mod('si_written_menu_drinks_section_7_item_4_price', '6');
    
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