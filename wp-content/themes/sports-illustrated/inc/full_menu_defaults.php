<?php
/**
 * Full Menu Defaults
 *
 * This file contains the default values for the full menu.
 *
 * @package Sports_Illustrated
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define full menu defaults
$full_defaults = array(
    // Full Menu Header
    'si_full_menu_title' => 'Main Menu',
    'si_full_menu_subtitle' => 'Available Daily from 11am - 10pm',
    
    // Appetizers
    'si_full_appetizers_title' => 'Starters',
    'si_full_appetizers_description' => 'Perfect for sharing or enjoying on your own',
    
    // Appetizer 1
    'si_full_appetizer_1_name' => 'Loaded Nachos',
    'si_full_appetizer_1_price' => '14',
    'si_full_appetizer_1_description' => 'Tortilla chips, queso, jalapeños, pico de gallo, guacamole, sour cream',
    'si_full_appetizer_1_notes' => 'V, GF',
    'si_full_appetizer_1_visible' => true,
    
    // Appetizer 2
    'si_full_appetizer_2_name' => 'Chicken Wings',
    'si_full_appetizer_2_price' => '16',
    'si_full_appetizer_2_description' => 'Choice of buffalo, BBQ, or garlic parmesan, served with celery and blue cheese',
    'si_full_appetizer_2_notes' => 'GF',
    'si_full_appetizer_2_visible' => true,
    
    // Appetizer 3
    'si_full_appetizer_3_name' => 'Spinach Artichoke Dip',
    'si_full_appetizer_3_price' => '13',
    'si_full_appetizer_3_description' => 'Creamy spinach and artichoke dip, served with tortilla chips',
    'si_full_appetizer_3_notes' => 'V',
    'si_full_appetizer_3_visible' => true,
    
    // Appetizer 4
    'si_full_appetizer_4_name' => 'Mozzarella Sticks',
    'si_full_appetizer_4_price' => '12',
    'si_full_appetizer_4_description' => 'Breaded mozzarella, marinara sauce',
    'si_full_appetizer_4_notes' => 'V',
    'si_full_appetizer_4_visible' => true,
    
    // Appetizer 5
    'si_full_appetizer_5_name' => 'Loaded Potato Skins',
    'si_full_appetizer_5_price' => '13',
    'si_full_appetizer_5_description' => 'Crispy potato skins, cheddar cheese, bacon, green onions, sour cream',
    'si_full_appetizer_5_notes' => 'GF',
    'si_full_appetizer_5_visible' => true,
    
    // Salads
    'si_full_salads_title' => 'Salads',
    'si_full_salads_description' => 'Fresh and flavorful salads',
    
    // Salad 1
    'si_full_salad_1_name' => 'Caesar Salad',
    'si_full_salad_1_price' => '12',
    'si_full_salad_1_description' => 'Romaine lettuce, parmesan, croutons, caesar dressing',
    'si_full_salad_1_notes' => '',
    'si_full_salad_1_visible' => true,
    
    // Salad 2
    'si_full_salad_2_name' => 'Cobb Salad',
    'si_full_salad_2_price' => '16',
    'si_full_salad_2_description' => 'Mixed greens, grilled chicken, bacon, avocado, blue cheese, tomato, egg, ranch dressing',
    'si_full_salad_2_notes' => 'GF',
    'si_full_salad_2_visible' => true,
    
    // Salad 3
    'si_full_salad_3_name' => 'Greek Salad',
    'si_full_salad_3_price' => '14',
    'si_full_salad_3_description' => 'Mixed greens, feta, kalamata olives, cucumber, tomato, red onion, bell pepper, Greek dressing',
    'si_full_salad_3_notes' => 'V, GF',
    'si_full_salad_3_visible' => true,
    
    // Burgers & Sandwiches
    'si_full_burgers_title' => 'Burgers & Sandwiches',
    'si_full_burgers_description' => 'Served with fries or side salad',
    
    // Burger 1
    'si_full_burger_1_name' => 'Classic Cheeseburger',
    'si_full_burger_1_price' => '17',
    'si_full_burger_1_description' => '8oz Angus beef patty, American cheese, lettuce, tomato, onion, pickle, brioche bun',
    'si_full_burger_1_notes' => '',
    'si_full_burger_1_visible' => true,
    
    // Burger 2
    'si_full_burger_2_name' => 'Bacon Avocado Burger',
    'si_full_burger_2_price' => '19',
    'si_full_burger_2_description' => '8oz Angus beef patty, bacon, avocado, cheddar, lettuce, tomato, onion, brioche bun',
    'si_full_burger_2_notes' => '',
    'si_full_burger_2_visible' => true,
    
    // Burger 3
    'si_full_burger_3_name' => 'Grilled Chicken Sandwich',
    'si_full_burger_3_price' => '16',
    'si_full_burger_3_description' => 'Grilled chicken breast, provolone, lettuce, tomato, pesto aioli, ciabatta',
    'si_full_burger_3_notes' => '',
    'si_full_burger_3_visible' => true,
    
    // Burger 4
    'si_full_burger_4_name' => 'Club Sandwich',
    'si_full_burger_4_price' => '15',
    'si_full_burger_4_description' => 'Turkey, ham, bacon, cheddar, lettuce, tomato, mayo, toasted sourdough',
    'si_full_burger_4_notes' => '',
    'si_full_burger_4_visible' => true,
    
    // Burger 5
    'si_full_burger_5_name' => 'Veggie Burger',
    'si_full_burger_5_price' => '16',
    'si_full_burger_5_description' => 'Plant-based patty, lettuce, tomato, onion, pickle, vegan aioli, whole grain bun',
    'si_full_burger_5_notes' => 'V',
    'si_full_burger_5_visible' => true,
    
    // Mains
    'si_full_mains_title' => 'Main Plates',
    'si_full_mains_description' => 'Hearty entrees to satisfy your appetite',
    
    // Main 1
    'si_full_main_1_name' => 'Grilled Ribeye',
    'si_full_main_1_price' => '32',
    'si_full_main_1_description' => '12oz ribeye, garlic mashed potatoes, seasonal vegetables, herb butter',
    'si_full_main_1_notes' => 'GF',
    'si_full_main_1_visible' => true,
    
    // Main 2
    'si_full_main_2_name' => 'Fish & Chips',
    'si_full_main_2_price' => '22',
    'si_full_main_2_description' => 'Beer-battered cod, french fries, coleslaw, tartar sauce',
    'si_full_main_2_notes' => '',
    'si_full_main_2_visible' => true,
    
    // Main 3
    'si_full_main_3_name' => 'Chicken Parmesan',
    'si_full_main_3_price' => '24',
    'si_full_main_3_description' => 'Breaded chicken breast, marinara, mozzarella, parmesan, spaghetti',
    'si_full_main_3_notes' => '',
    'si_full_main_3_visible' => true,
    
    // Main 4
    'si_full_main_4_name' => 'BBQ Ribs',
    'si_full_main_4_price' => '28',
    'si_full_main_4_description' => 'Full rack of baby back ribs, house BBQ sauce, coleslaw, french fries',
    'si_full_main_4_notes' => 'GF',
    'si_full_main_4_visible' => true,
    
    // Main 5
    'si_full_main_5_name' => 'Grilled Salmon',
    'si_full_main_5_price' => '26',
    'si_full_main_5_description' => 'Atlantic salmon, wild rice pilaf, seasonal vegetables, lemon butter sauce',
    'si_full_main_5_notes' => 'GF',
    'si_full_main_5_visible' => true,
    
    // Sides
    'si_full_sides_title' => 'Sides',
    'si_full_sides_description' => 'Perfect additions to complete your meal',
    
    // Side 1
    'si_full_side_1_name' => 'French Fries',
    'si_full_side_1_price' => '6',
    'si_full_side_1_description' => 'Crispy golden fries',
    'si_full_side_1_notes' => 'V, GF',
    'si_full_side_1_visible' => true,
    
    // Side 2
    'si_full_side_2_name' => 'Onion Rings',
    'si_full_side_2_price' => '7',
    'si_full_side_2_description' => 'Beer-battered onion rings',
    'si_full_side_2_notes' => 'V',
    'si_full_side_2_visible' => true,
    
    // Side 3
    'si_full_side_3_name' => 'Mac & Cheese',
    'si_full_side_3_price' => '8',
    'si_full_side_3_description' => 'Creamy three-cheese blend',
    'si_full_side_3_notes' => 'V',
    'si_full_side_3_visible' => true,
    
    // Side 4
    'si_full_side_4_name' => 'Seasonal Vegetables',
    'si_full_side_4_price' => '6',
    'si_full_side_4_description' => 'Chef\'s selection of seasonal vegetables',
    'si_full_side_4_notes' => 'V, GF',
    'si_full_side_4_visible' => true,
    
    // Side 5
    'si_full_side_5_name' => 'Side Salad',
    'si_full_side_5_price' => '5',
    'si_full_side_5_description' => 'Mixed greens, tomato, cucumber, red onion, choice of dressing',
    'si_full_side_5_notes' => 'V, GF',
    'si_full_side_5_visible' => true,
    
    // Desserts
    'si_full_desserts_title' => 'Desserts',
    'si_full_desserts_description' => 'Sweet treats to end your meal',
    
    // Dessert 1
    'si_full_dessert_1_name' => 'New York Cheesecake',
    'si_full_dessert_1_price' => '10',
    'si_full_dessert_1_description' => 'Classic cheesecake, graham cracker crust, berry compote',
    'si_full_dessert_1_notes' => 'V',
    'si_full_dessert_1_visible' => true,
    
    // Dessert 2
    'si_full_dessert_2_name' => 'Chocolate Lava Cake',
    'si_full_dessert_2_price' => '11',
    'si_full_dessert_2_description' => 'Warm chocolate cake, molten center, vanilla ice cream',
    'si_full_dessert_2_notes' => 'V',
    'si_full_dessert_2_visible' => true,
    
    // Dessert 3
    'si_full_dessert_3_name' => 'Apple Pie',
    'si_full_dessert_3_price' => '9',
    'si_full_dessert_3_description' => 'Warm apple pie, cinnamon, caramel sauce, whipped cream',
    'si_full_dessert_3_notes' => 'V',
    'si_full_dessert_3_visible' => true,
); 