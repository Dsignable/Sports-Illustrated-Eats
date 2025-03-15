<?php
/**
 * The footer template file
 *
 * @package Sports_Illustrated
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="site-info">
                <?php
                printf(
                    /* translators: %s: Current year. */
                    esc_html__('© %s Sports Illustrated Clubhouse. All rights reserved.', 'sports-illustrated'),
                    date('Y')
                );
                ?>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html> 