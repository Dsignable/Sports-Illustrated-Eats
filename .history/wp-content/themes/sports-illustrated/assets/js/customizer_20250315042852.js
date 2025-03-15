/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
    'use strict';

    // Menu dropdown text and URL updates
    const menuItems = ['full', 'drink', 'brunch', 'happy', 'today'];
    
    // Update menu dropdown text
    menuItems.forEach(function(key) {
        wp.customize('si_menu_dropdown_text_' + key, function(value) {
            value.bind(function(newval) {
                $('.menu-dropdown a[data-menu-type="' + key + '"]').text(newval);
            });
        });
        
        // Update menu dropdown URLs
        wp.customize('si_menu_dropdown_url_' + key, function(value) {
            value.bind(function(newval) {
                $('.menu-dropdown a[data-menu-type="' + key + '"]').attr('href', newval);
            });
        });
    });

    // Left menu items
    for (let i = 1; i <= 3; i++) {
        // Update left menu text
        wp.customize('si_left_menu_text_' + i, function(value) {
            value.bind(function(newval) {
                $('.left-menu .nav-button:nth-child(' + i + ')').text(newval);
            });
        });
        
        // Update left menu URLs
        wp.customize('si_left_menu_url_' + i, function(value) {
            value.bind(function(newval) {
                $('.left-menu .nav-button:nth-child(' + i + ')').attr('href', newval);
            });
        });
        
        // Toggle left menu visibility
        wp.customize('si_left_menu_visible_' + i, function(value) {
            value.bind(function(newval) {
                if (newval) {
                    $('.left-menu .nav-button:nth-child(' + i + ')').show();
                } else {
                    $('.left-menu .nav-button:nth-child(' + i + ')').hide();
                }
            });
        });
    }
    
    // Right menu items
    for (let i = 1; i <= 3; i++) {
        // Update right menu text
        wp.customize('si_right_menu_text_' + i, function(value) {
            value.bind(function(newval) {
                $('.right-menu .nav-button:nth-child(' + i + ')').text(newval);
            });
        });
        
        // Update right menu URLs
        wp.customize('si_right_menu_url_' + i, function(value) {
            value.bind(function(newval) {
                $('.right-menu .nav-button:nth-child(' + i + ')').attr('href', newval);
            });
        });
        
        // Toggle right menu visibility
        wp.customize('si_right_menu_visible_' + i, function(value) {
            value.bind(function(newval) {
                if (newval) {
                    $('.right-menu .nav-button:nth-child(' + i + ')').parent().show();
                } else {
                    $('.right-menu .nav-button:nth-child(' + i + ')').parent().hide();
                }
            });
        });
        
        // Right menu dropdown items
        for (let j = 1; j <= 5; j++) {
            // Update dropdown text
            wp.customize('si_right_menu_dropdown_' + i + '_text_' + j, function(value) {
                value.bind(function(newval) {
                    $('.right-menu .menu-dropdown-wrapper:nth-child(' + i + ') .dropdown-item:nth-child(' + j + ')').text(newval);
                });
            });
            
            // Update dropdown URLs
            wp.customize('si_right_menu_dropdown_' + i + '_url_' + j, function(value) {
                value.bind(function(newval) {
                    $('.right-menu .menu-dropdown-wrapper:nth-child(' + i + ') .dropdown-item:nth-child(' + j + ')').attr('href', newval);
                });
            });
            
            // Toggle dropdown item visibility
            wp.customize('si_right_menu_dropdown_' + i + '_visible_' + j, function(value) {
                value.bind(function(newval) {
                    if (newval) {
                        $('.right-menu .menu-dropdown-wrapper:nth-child(' + i + ') .dropdown-item:nth-child(' + j + ')').show();
                    } else {
                        $('.right-menu .menu-dropdown-wrapper:nth-child(' + i + ') .dropdown-item:nth-child(' + j + ')').hide();
                    }
                });
            });
        }
    }

} )( jQuery ); 