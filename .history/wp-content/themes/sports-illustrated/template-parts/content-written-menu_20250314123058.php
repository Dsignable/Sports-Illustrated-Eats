<?php
/**
 * Template part for displaying written menus
 *
 * @package Sports_Illustrated
 */

// Get the menu type from the parameter
$menu_type = isset($args['menu_type']) ? $args['menu_type'] : 'full';
$menu_title = get_theme_mod("si_written_menu_{$menu_type}_title", ucfirst($menu_type) . ' Menu');
$menu_description = get_theme_mod("si_written_menu_{$menu_type}_description", '');
$menu_pdf = isset($args['menu_pdf']) ? $args['menu_pdf'] : '';
?>

<div class="written-menu-container <?php echo esc_attr($menu_type); ?>-menu">
    <div class="written-menu-header">
        <h1 class="written-menu-title"><?php echo esc_html($menu_title); ?></h1>
        <?php if (!empty($menu_description)) : ?>
            <div class="written-menu-description">
                <?php echo wp_kses_post($menu_description); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="written-menu-content">
        <?php
        // Loop through menu sections
        for ($i = 1; $i <= 10; $i++) {
            $section_title = get_theme_mod("si_written_menu_{$menu_type}_section_{$i}_title", '');
            $section_description = get_theme_mod("si_written_menu_{$menu_type}_section_{$i}_description", '');
            
            // Skip empty sections
            if (empty($section_title)) {
                continue;
            }
            ?>
            <div class="menu-section" id="<?php echo esc_attr($menu_type . '-section-' . $i); ?>">
                <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
                
                <?php if (!empty($section_description)) : ?>
                    <div class="section-description">
                        <?php echo wp_kses_post($section_description); ?>
                    </div>
                <?php endif; ?>
                
                <div class="menu-items">
                    <?php
                    // Loop through menu items
                    $current_subsection = '';
                    for ($j = 1; $j <= 15; $j++) {
                        $item_name = get_theme_mod("si_written_menu_{$menu_type}_section_{$i}_item_{$j}_name", '');
                        $item_description = get_theme_mod("si_written_menu_{$menu_type}_section_{$i}_item_{$j}_description", '');
                        $item_price = get_theme_mod("si_written_menu_{$menu_type}_section_{$i}_item_{$j}_price", '');
                        $item_notes = get_theme_mod("si_written_menu_{$menu_type}_section_{$i}_item_{$j}_notes", '');
                        
                        // Skip empty items
                        if (empty($item_name)) {
                            continue;
                        }
                        
                        // Check if this is a subsection header
                        if ($item_notes === 'subsection') {
                            $current_subsection = $item_name;
                            ?>
                            <div class="menu-subsection">
                                <h3 class="subsection-title"><?php echo esc_html($item_name); ?></h3>
                                <?php if (!empty($item_description)) : ?>
                                    <div class="subsection-description">
                                        <?php echo wp_kses_post($item_description); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php
                            continue;
                        }
                        ?>
                        <div class="menu-item <?php echo !empty($current_subsection) ? 'subsection-item' : ''; ?>">
                            <div class="item-header">
                                <h3 class="item-name"><?php echo esc_html($item_name); ?></h3>
                                <?php if (!empty($item_price)) : ?>
                                    <span class="item-price"><?php echo esc_html($item_price); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if (!empty($item_description)) : ?>
                                <div class="item-description">
                                    <?php echo wp_kses_post($item_description); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($item_notes) && $item_notes !== 'subsection') : ?>
                                <div class="item-notes">
                                    <?php echo esc_html($item_notes); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <?php if (!empty($menu_pdf)) : ?>
    <div class="menu-pdf-download">
        <a href="<?php echo esc_url($menu_pdf); ?>" target="_blank" class="download-btn">
            <span class="dashicons dashicons-pdf"></span> Download PDF
        </a>
    </div>
    <?php endif; ?>
</div> 