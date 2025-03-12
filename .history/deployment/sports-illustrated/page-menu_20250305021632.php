                <?php
                // Burger Menu
                $burger_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/BurgerManiaMenu-1.jpg";
                ?>
                <img src="<?php echo esc_url($burger_menu_image); ?>" 
                     class="menu-image" 
                     data-menu="burger"
                     alt="Burger Menu"
                     style="display: none;">

                <?php
                // Today's Menu - Using switch statement for different days
                $today = strtolower(date('l')); // Gets current day of week
                $today_menu_image = '';
                
                switch($today) {
                    case 'monday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Monday-Menu.jpg";
                        break;
                    case 'tuesday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Tuesday-Menu.jpg";
                        break;
                    case 'wednesday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Wednesday-Menu.jpg";
                        break;
                    case 'thursday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Thursday-Menu.jpg";
                        break;
                    case 'friday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Friday-Menu.jpg";
                        break;
                    case 'saturday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Saturday-Menu.jpg";
                        break;
                    case 'sunday':
                        $today_menu_image = "https://sportsillustratedeats.com/wp-content/uploads/2025/03/Sunday-Menu.jpg";
                        break;
                }
                
                if ($today_menu_image) : // Only show if we have an image for today
                ?>
                <img src="<?php echo esc_url($today_menu_image); ?>" 
                     class="menu-image" 
                     data-menu="today"
                     alt="<?php echo ucfirst($today); ?>'s Menu"
                     style="display: none;">
                <?php endif; ?>
            </div>
        </section> 