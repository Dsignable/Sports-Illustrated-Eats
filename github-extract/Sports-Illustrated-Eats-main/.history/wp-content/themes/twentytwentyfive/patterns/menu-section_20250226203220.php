<?php
/**
 * Title: Menu Section
 * Slug: twentytwentyfive/menu-section
 * Categories: featured
 */
?>

<section class="menu-items">
  <article class="menu-card happy-hour">
    <div class="menu-card-content">
      <img
        src="<?php echo esc_url(get_theme_file_uri('assets/images/happy-hour-menu.jpg')); ?>"
        alt="<?php esc_attr_e('Happy Hour Menu', 'twentytwentyfive'); ?>"
        class="menu-image"
      />
      <h2 class="menu-title happy-hour-title">
        <?php esc_html_e('HAPPY', 'twentytwentyfive'); ?>
        <br />
        <?php esc_html_e('HOUR', 'twentytwentyfive'); ?>
      </h2>
    </div>
  </article>

  <article class="menu-card fan-favorites">
    <div class="menu-card-content">
      <img
        src="<?php echo esc_url(get_theme_file_uri('assets/images/fan-favorites-menu.jpg')); ?>"
        alt="<?php esc_attr_e('Fan Favorites Menu', 'twentytwentyfive'); ?>"
        class="menu-image"
      />
      <h2 class="menu-title fan-favorites-title">
        <?php esc_html_e('FAN', 'twentytwentyfive'); ?>
        <br />
        <?php esc_html_e('FAVORITES', 'twentytwentyfive'); ?>
      </h2>
    </div>
  </article>

  <article class="menu-card drinks-cocktails">
    <div class="menu-card-content">
      <img
        src="<?php echo esc_url(get_theme_file_uri('assets/images/drinks-cocktails-menu.jpg')); ?>"
        alt="<?php esc_attr_e('Drinks & Cocktails Menu', 'twentytwentyfive'); ?>"
        class="menu-image"
      />
      <h2 class="menu-title drinks-cocktails-title">
        <?php esc_html_e('DRINKS &', 'twentytwentyfive'); ?>
        <br />
        <?php esc_html_e('COCKTAILS', 'twentytwentyfive'); ?>
      </h2>
    </div>
  </article>
</section> 