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
                if (i === 1) {
                    $('.left-menu .has-dropdown').text(newval);
                } else {
                    $('.left-menu .nav-button:not(.has-dropdown)').eq(i-2).text(newval);
                }
            });
        });
        
        // Update left menu URLs
        wp.customize('si_left_menu_url_' + i, function(value) {
            value.bind(function(newval) {
                if (i === 1) {
                    $('.left-menu .has-dropdown').attr('href', newval);
                } else {
                    $('.left-menu .nav-button:not(.has-dropdown)').eq(i-2).attr('href', newval);
                }
            });
        });
        
        // Toggle left menu visibility
        wp.customize('si_left_menu_visible_' + i, function(value) {
            value.bind(function(newval) {
                if (i === 1) {
                    if (newval) {
                        $('.left-menu .menu-dropdown-wrapper').show();
                    } else {
                        $('.left-menu .menu-dropdown-wrapper').hide();
                    }
                } else {
                    const $item = $('.left-menu .nav-button:not(.has-dropdown)').eq(i-2);
                    if (newval) {
                        $item.show();
                    } else {
                        $item.hide();
                    }
                }
            });
        });
    }
    
    // Right menu items
    for (let i = 1; i <= 3; i++) {
        // Update right menu text
        wp.customize('si_right_menu_text_' + i, function(value) {
            value.bind(function(newval) {
                const $item = $('.right-menu > a.nav-button, .right-menu > div > a.nav-button').eq(i-1);
                $item.text(newval);
            });
        });
        
        // Update right menu URLs
        wp.customize('si_right_menu_url_' + i, function(value) {
            value.bind(function(newval) {
                const $item = $('.right-menu > a.nav-button, .right-menu > div > a.nav-button').eq(i-1);
                $item.attr('href', newval);
            });
        });
        
        // Toggle right menu visibility
        wp.customize('si_right_menu_visible_' + i, function(value) {
            value.bind(function(newval) {
                const $item = $('.right-menu > a.nav-button, .right-menu > div').eq(i-1);
                if (newval) {
                    $item.show();
                } else {
                    $item.hide();
                }
            });
        });
        
        // Right menu dropdown items
        for (let j = 1; j <= 5; j++) {
            // Update dropdown text
            wp.customize('si_right_menu_dropdown_' + i + '_text_' + j, function(value) {
                value.bind(function(newval) {
                    const $dropdown = $('.right-menu > div').eq(i-1).find('.menu-dropdown');
                    const $item = $dropdown.find('a.dropdown-item').eq(j-1);
                    $item.text(newval);
                });
            });
            
            // Update dropdown URLs
            wp.customize('si_right_menu_dropdown_' + i + '_url_' + j, function(value) {
                value.bind(function(newval) {
                    const $dropdown = $('.right-menu > div').eq(i-1).find('.menu-dropdown');
                    const $item = $dropdown.find('a.dropdown-item').eq(j-1);
                    $item.attr('href', newval);
                });
            });
            
            // Toggle dropdown item visibility
            wp.customize('si_right_menu_dropdown_' + i + '_visible_' + j, function(value) {
                value.bind(function(newval) {
                    const $dropdown = $('.right-menu > div').eq(i-1).find('.menu-dropdown');
                    const $item = $dropdown.find('a.dropdown-item').eq(j-1);
                    if (newval) {
                        $item.show();
                    } else {
                        $item.hide();
                    }
                });
            });
        }
    }

} )( jQuery ); 