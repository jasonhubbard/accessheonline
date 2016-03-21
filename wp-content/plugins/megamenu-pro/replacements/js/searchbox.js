/*jslint browser: true, white: true */
/*global console,jQuery,megamenu,window,navigator*/

/**
 * Max Mega Menu Searchbox jQuery plugin
 */
(function($) {

    "use strict";

    $.maxmegamenu_searchbox = function(menu, options) {

        var plugin = this;
        var $menu = $(menu);
        var $wrap = $menu.parent();
        var breakpoint = $menu.attr('data-breakpoint');

        var is_mobile = function() {
            return $(window).width() <= breakpoint;
        };

        plugin.init = function() {

            if ( is_mobile() ) {
                $(".mega-search.expand-to-left .search-icon", $menu).on('click', function(e) {
                    $(this).parents(".mega-search").submit();
                });
            } else {
                $(".mega-search .search-icon", $menu).on('click', function(e) {

                    var input = $(this).parents('.mega-search').children('input[type=text]');
                    var form = $(this).parents('.mega-search');

                    if (form.hasClass('static') ) {
                        form.submit();
                    } else if (form.hasClass('mega-search-closed')) {
                        input.focus();
                        input.attr('placeholder', input.attr('data-placeholder'));
                        form.removeClass('mega-search-closed');
                        form.addClass('mega-search-open');
                    } else if ( input.val() == '' ) {
                        form.addClass('mega-search-closed');
                        form.removeClass('mega-search-open');
                        input.attr('placeholder', '');
                    } else {
                        form.submit();
                    }
                });
            }

        };

        plugin.init();

    };

    $.fn.maxmegamenu_searchbox = function(options) {

        return this.each(function() {
            if (undefined === $(this).data('maxmegamenu_searchbox')) {
                var plugin = new $.maxmegamenu_searchbox(this, options);
                $(this).data('maxmegamenu_searchbox', plugin);
            }
        });

    };

    $(function() {
        $(".mega-menu").maxmegamenu_searchbox();
    });

})(jQuery);