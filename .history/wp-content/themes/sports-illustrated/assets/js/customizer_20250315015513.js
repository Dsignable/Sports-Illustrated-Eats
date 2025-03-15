/**
 * Sports Illustrated Customizer JS
 * 
 * Ensures proper display and functionality of customizer controls
 */
(function($) {
    'use strict';

    // When the customizer is ready
    wp.customize.bind('ready', function() {
        // Make sure menu dropdown URL controls are visible
        const menuItems = ['full', 'drink', 'brunch', 'happy', 'today'];
        
        menuItems.forEach(function(key) {
            // Ensure URL controls are visible
            const urlControl = wp.customize.control('si_menu_dropdown_url_' + key);
            if (urlControl) {
                urlControl.container.css('display', 'block');
                urlControl.container.find('input').css({
                    'width': '100%',
                    'margin-top': '5px'
                });
            }
        });
        
        // Toggle visibility of menu dropdown controls based on the "Enable Menu Dropdown" setting
        wp.customize('si_enable_menu_dropdown', function(setting) {
            setting.bind(function(value) {
                menuItems.forEach(function(key) {
                    const textControl = wp.customize.control('si_menu_dropdown_text_' + key);
                    const urlControl = wp.customize.control('si_menu_dropdown_url_' + key);
                    const visibleControl = wp.customize.control('si_menu_dropdown_visible_' + key);
                    const dividerControl = wp.customize.control('si_menu_dropdown_divider_' + key);
                    
                    if (textControl) textControl.container.toggle(value);
                    if (urlControl) urlControl.container.toggle(value);
                    if (visibleControl) visibleControl.container.toggle(value);
                    if (dividerControl) dividerControl.container.toggle(value);
                });
            });
            
            // Trigger the change to set initial state
            setting.callbacks.fireWith(setting, [setting.get()]);
        });
    });

})(jQuery); 