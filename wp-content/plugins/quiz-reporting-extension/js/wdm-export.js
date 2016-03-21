var wdmAEL = '';
var wdmqe_html = '';

jQuery(document).ready(function() {

    /* makes ajax request and pull data in JSON format, and creates <form> to submit data to generate .CSV file
     */
    jQuery("body").delegate(".wdm-export", "click", function(e) {
        e.preventDefault();
        console.log(jQuery(this).hasClass('wdm-exp-csv'));
        console.log(jQuery(this).hasClass('wdm-exp-xls'));

        var that = jQuery(this);
        var ref_id = that.attr('data-ref_id');
        if (that.hasClass('wdm-exp-csv'))
            var format = 'csv';
        if (that.hasClass('wdm-exp-xls'))
            var format = 'xls';
        jQuery("#wdm_exp_form_" + wdm_export_obj.wdm_nonce).remove(); // removes previously generated form
        jQuery("#wdm_error").remove(); // removes previously generated errors

        that.append('<img src="' + wdm_export_obj.loader_link + '" height=20 style="margin-top:15px;" id="wdm_loader" />');

        if (ref_id !== "" && ref_id !== "undefined") {

            that.find('form').remove();
            var html_str = '<form id="wdm_exp_form_' + wdm_export_obj.wdm_nonce + '" method="post" action="" target="_blank" style="display:none;">' +
                '<input name="wdm_format" type="hidden" value="' + format + '">' +
                '<input name="ref_id" type="hidden" value="' + ref_id + '">' +
                '<input name="wdm_nonce" type="hidden" value="' + wdm_export_obj.wdm_nonce + '">' +
                '</form>';
            that.append(html_str);
            // console.log(html_str);
            that.find('form').submit();
            jQuery("#wdm_loader").remove();
            /*
            jQuery.ajax( {
                url: wdm_export_obj.ajax_url,
                data: { "action": "wdm_export", "ref_id": ref_id, "wdm_nonce": wdm_export_obj.wdm_nonce, "format": format },
                type: "post",
                dataType: "json",
                timeout: 60000 // 1 minute
            } ).done( function ( data ) {
                //console.log( data );
                if ( data ) {
                    // creating html string of form
                    //For CSV format
                    if ( format === 'csv' ) {
                        var html_str = '<form method="post" id="wdm_exp_form_' + ref_id + '_csv" action="' + wdm_export_obj.export_link + '" target="_blank" style="display:none;"><textarea name="wdm_export_data">' + data.table + '</textarea><input type="text" name="wdm_uname" value="' + data.name + '" /><input type="text" name="wdm_quiz" value="' + data.quiz_title + '" /><input name="wdm_format" type="hidden" value="' + format + '"></form>';
                        that.append( html_str );

                        document.getElementById( "wdm_exp_form_" + ref_id + '_csv' ).submit(); // submitting created form

                    }
                    //For xls format
                    if ( format === 'xls' ) {
                        var html_str = '<form method="post" id="wdm_exp_form_' + ref_id + '_xls" action="' + wdm_export_obj.export_link + '" target="_blank" style="display:none;"><textarea name="wdm_export_data">' + data.table + '</textarea><input type="text" name="wdm_uname" value="' + data.name + '" /><input type="text" name="wdm_quiz" value="' + data.quiz_title + '" /><input name="wdm_format" type="hidden" value="' + format + '"></form>';
                        that.append( html_str );

                        document.getElementById( "wdm_exp_form_" + ref_id + '_xls' ).submit(); // submitting created form
                    }
                    jQuery( "#wdm_loader" ).remove();
                } else {
                    that.append( "<span style='color:red;' id='wdm_error'> Error!!!</span>" );
                    jQuery( "#wdm_loader" ).remove();
                }

            } ).fail( function ( jqXHR, textStatus ) {
                if ( 'timeout' === textStatus ) { // if timeout
                    that.append( "<span style='color:red;' id='wdm_error'> Request Timeout!!!</span>" );
                    jQuery( "#wdm_loader" ).remove();
                }
            } );
            */

        }
    });

    // to add all stat IDs to export in export all button
    if (wdm_export_obj.all_ids != 'undefinded' && wdm_export_obj.all_ids != '') {
        jQuery(".wpProQuiz_update").before('<a id="wdm_export_all" href="#" data-ref_id="' + wdm_export_obj.all_ids + '" class="wdm-export button-secondary wdm-exp-csv" style="margin-right:3px;">Export All in CSV </a><a id="wdm_export_all" href="#" data-ref_id="' + wdm_export_obj.all_ids + '" class="wdm-export button-secondary wdm-exp-xls" style="margin-right:3px;">Export All in Excel </a>');
    }

});


/* adds EXPORT link 
 */
function wdmAddExportLink() {

    // to check if content is updated then run our function
    wdmqe_html_check = jQuery("#wpProQuiz_historyLoadContext tr").eq(1).html();

    // This has been added because, only checking of HTML element was not sufficient. This will check for number of rows in the div
    // If rows are zero then don't clear interval.
    var wdm_num_tr = jQuery("#wpProQuiz_historyLoadContext tr").length;
    //console.log(wdm_num_tr);
    if (wdm_num_tr == 0) {
        return false;
    }

    //if ( jQuery( "#wpProQuiz_statistics_form_data" ).length > 0 ) { // if Learndash core ajax call is completed append links

    // if data not found, clear interval
    if (typeof wdmqe_html_check != 'undefined') {
        if (wdmqe_html_check.length < 200) {
            clearInterval(wdmAEL);
        }
    }

    // if content is updated than add column
    if (wdmqe_html != wdmqe_html_check) {

        jQuery("#wdm_all_Exportexport").remove(); // removes <th> of a export column
        jQuery('.wdm-export-th').remove(); // removes all <td> of a export column

        jQuery("#wpProQuiz_historyLoadContext .wp-list-table > thead > tr").append("<th id='wdm_all_Exportexport'>Export</th>");

        var wdm_all_ref_ids = '';

        jQuery("#wpProQuiz_statistics_form_data > tr").each(function() {

            var ref_id = jQuery(this).find(".user_statistic").attr("data-ref_id");

            if (ref_id !== "" && ref_id != undefined) {
                /* wdm-exp-xls  wdm-exp-csv*/
                //jQuery( '.wdm-export-th' ).remove();
                jQuery(this).append("<th class='wdm-export-th'>Export Response <a href='#' data-ref_id='" + ref_id + "' class=\"wdm-export  wdm-exp-csv\"> CSV </a>/<a href='#' data-ref_id='" + ref_id + "' class=\"wdm-export  wdm-exp-xls\"> Excel </a></th>");
                //console.log("<th class='wdm-export-th'>Export Response <a href='#' data-ref_id='" + ref_id + "' class=\"wdm-export  wdm-exp-csv\"> CSV </a>/<a href='#' data-ref_id='" + ref_id + "' class=\"wdm-export  wdm-exp-xls\"> Excel </a></th>");

                wdm_all_ref_ids += ref_id + ',';

            }

        });

        //console.log('wdm_all_ref_ids='+wdm_all_ref_ids);

        wdm_all_ref_ids = wdm_all_ref_ids.substring(0, wdm_all_ref_ids.length - 1);

        if (wdm_all_ref_ids !== '') {
            // jQuery( ".wpProQuiz_update" ).before(  '<a id="wdm_export_all" href="#" data-ref_id="' + wdm_all_ref_ids + '" class="wdm-export button-secondary" style="margin-right:3px;">Export</a>'  );
            //jQuery( '#wdm_all_export' ).html( '<a href="#" data-ref_id="' + wdm_all_ref_ids + '" class="wdm-export">Export</a>' );

        }
        clearInterval(wdmAEL);

    }
}

wdmAEL = setInterval(wdmAddExportLink, 500);

// to add export links after clicking "refresh" button
jQuery(".wpProQuiz_update,#filter").on("click", function() {
    wdmqe_html = jQuery("#wpProQuiz_historyLoadContext tr").eq(1).html();
    wdmAEL = setInterval(wdmAddExportLink, 500);
});
// on click of navigation buttons
jQuery("#historyNavigation .navigationRight,#historyNavigation .navigationLeft").on("click", function() {

    wdmqe_html = jQuery("#wpProQuiz_historyLoadContext tr").eq(1).html();
    wdmAEL = setInterval(wdmAddExportLink, 500);

});
// on change of dropdown in navigation menu
jQuery(".navigationCurrentPage").on("change", function() {

    wdmqe_html = jQuery("#wpProQuiz_historyLoadContext tr").eq(1).html();
    wdmAEL = setInterval(wdmAddExportLink, 500);

});
// on click of "History" tab
jQuery(".wpProQuiz_tab_wrapper a").click(function() {

    if (jQuery(this).attr('data-tab') == '#wpProQuiz_tabHistory') {
        wdmqe_html = jQuery("#wpProQuiz_historyLoadContext tr").eq(1).html();
        wdmAEL = setInterval(wdmAddExportLink, 500);
    }

});