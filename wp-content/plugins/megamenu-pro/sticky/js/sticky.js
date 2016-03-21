/*jslint browser: true, white: true */
/*global console,jQuery,megamenu,window,navigator*/

/**
 * Max Mega Menu Sticky jQuery Plugin
 */
(function($) {

    "use strict";

    $.maxmegamenu_sticky = function(menu, options) {

        var plugin = this;
        var $menu = $(menu);
        var $wrap = $menu.parent();
        var breakpoint = $menu.attr('data-breakpoint');
        var sticky_on_mobile = $menu.attr('data-sticky-mobile');
        var sticky_menu_offset_top;
        var sticky_menu_offset_left;
        var sticky_menu_width;
        var sticky_menu_height;
        var is_stuck = false;
        var admin_bar_height = 0;

        var sticky_enabled = function() {
            return $(window).width() > breakpoint || sticky_on_mobile === 'true';
        };

        var calculate_menu_position = function() {
            sticky_menu_offset_top = $wrap.offset().top;

            if ($('body.admin-bar').length && $(window).width() > breakpoint) {
                admin_bar_height = $('#wpadminbar').height();
                sticky_menu_offset_top = sticky_menu_offset_top - admin_bar_height;
            }

            sticky_menu_offset_left = $wrap.offset().left;
            sticky_menu_width = $wrap.width();
            sticky_menu_height = $wrap.height();
        };

        plugin.stick_menu = function() {

            if ( ! is_stuck ) {

            }
            is_stuck = true;

            var placeholder = $("<div />").css({
                'height' : sticky_menu_height + 'px',
                'position' :'static'
            });

            $wrap.addClass('mega-sticky').wrap(placeholder).css({
                'margin-top' : admin_bar_height + 'px'
            });

            $menu.css({
                'margin-left' : sticky_menu_offset_left + 'px',
                'max-width' : sticky_menu_width + 'px'
            });
        };

        plugin.unstick_menu = function() {
            is_stuck = false;

            $wrap.removeClass('mega-sticky').unwrap().css({
                'margin-top' : ''
            });

            $menu.css({
                'margin-left' : '',
                'max-width' : ''
            });
        };

        var mega_sticky_on_scroll = function(){
            if ( ! sticky_enabled() ) {
                return;
            }

            var scroll_top = $(window).scrollTop();

            if (scroll_top > sticky_menu_offset_top) {
                if (!is_stuck) {
                    plugin.stick_menu();
                }
            } else {
                if (is_stuck) {
                    plugin.unstick_menu();
                }
            }
        };

        var mega_sticky_on_resize = function() {

            if ( sticky_enabled() ) {

                if (is_stuck) {
                    plugin.unstick_menu();
                    calculate_menu_position();
                    plugin.stick_menu();
                } else {
                    calculate_menu_position();
                    mega_sticky_on_scroll();
                }

            } else {

                if (is_stuck) {
                    plugin.unstick_menu();
                }

            }
        };

        plugin.init = function() {

            calculate_menu_position();
            mega_sticky_on_scroll();

            $(window).scroll(function() {
                 mega_sticky_on_scroll();
            });

            $(window).resize(function() {
                mega_sticky_on_resize();
            });
        };

        plugin.init();

    };

    $.fn.maxmegamenu_sticky = function(options) {

        return this.each(function() {
            if (undefined === $(this).data('maxmegamenu_sticky')) {
                var plugin = new $.maxmegamenu_sticky(this, options);
                $(this).data('maxmegamenu_sticky', plugin);
            }
        });

    };

    $(function() {
        $(".mega-menu[data-sticky]").maxmegamenu_sticky();
    });

})(jQuery);