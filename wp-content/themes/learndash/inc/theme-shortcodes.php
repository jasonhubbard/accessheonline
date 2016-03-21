<?php
/**
 * Theme Shorcodes: Tabs,...
 *
 * @package nmbs
 */


/*/////////////////////////////////////////////////////////////////
 * NMBS tabs
 //////////////////////////////////////////////////////////////////

[tabs]
  [tab title="tab name 1" id="tab1"] Content here ...[/tab]
  [tab title="tab name 2" id="tab2"] Content here ...[/tab]
  [tab title="tab name 3" id="tab3"] Content here ...[/tab]
[/tabs]

*/

function tabs_group( $atts, $content = null ) {
    global $tabs_divs;
    // reset divs
    $tabs_divs = '';
    extract(shortcode_atts(array(  
        'id' => '',
        'class' => ''
    ), $atts));  
    $output = '<ul class="nav nav-tabs '.$class.'"  ';

    if(!empty($id))
        $output .= 'id="'.$id.'"';
    $output.='>'.do_shortcode($content).'</ul>';
    $output.= '<div class="tab-content">'.$tabs_divs.'</div>';
    return $output;  
} 
add_shortcode('tabs', 'tabs_group');

function tab($atts, $content = null) {  
    global $tabs_divs;
    extract(shortcode_atts(array(  
        'id' => '',
        'title' => '',
    ), $atts));  
    if(empty($id))
        $id = 'tab_item_'.rand(100,999);
    $output = '
        <li>
            <a href="#'.$id.'">'.$title.'</a>
        </li>
    ';
    $tabs_divs.= '<div class="tab-pane" id="'.$id.'">'.$content.'</div>';
    return $output;
}
add_shortcode('tab', 'tab');


/*/////////////////////////////////////////////////////////////////
 * NMBS Accordion
 //////////////////////////////////////////////////////////////////

[accordions]
  [accordion title="accordion name 1" id="accordion1"] Content here ...[/accordion]
  [accordion title="accordion name 2" id="accordion2"] Content here ...[/accordion]
  [accordion title="accordion name 3" id="accordion3"] Content here ...[/accordion]
[/accordions]

*/
function accordion_group( $atts, $content = null ) {
    global $parentid;
    extract(shortcode_atts(array(  
        'id' => '',
        'class' => ''
    ), $atts));  
    $output = '<div class="panel-group" ';

    if(empty($id))
        $parentid = 'accordion_'.rand(100,999);
        $output .= 'id="'.$parentid.'"';
    $output.='>'.do_shortcode($content).'</div>';
    return $output;  
} 
add_shortcode('accordions', 'accordion_group');

function accordion($atts, $content = null) { 
    global $parentid;
    extract(shortcode_atts(array(  
        'id' => '',
        'title' => '',
    ), $atts));  
    if(empty($id))
        $id = 'accordion_item_'.rand(100,999);
    $output = '
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#'.$parentid.'" href="#'.$id.'">'.$title.'</a>
            </h4>
          </div>
          <div id="'.$id.'" class="panel-collapse collapse">
            <div class="panel-body">'.$content.'</div>
          </div>
        </div>';
    return $output;
}
add_shortcode('accordion', 'accordion');

/*/////////////////////////////////////////////////////////////////
 * NMBS Alerts
 //////////////////////////////////////////////////////////////////

[alert type="warning" close="true"] Content here ...[/alert]
[alert type="info" close="false"] Content here ...[/alert]
[alert type="success" close="false"] Content here ...[/alert]
[alert type="danger" close="false"] Content here ...[/alert]

*/
function alert( $atts, $content = null ) {
   $layout="";
        extract(shortcode_atts(array(
            'type' => 'info',
            'close' => 'false',
       ), $atts));
    if($close == 'true')
        $close = '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>';
    $layout =  '<div class="alert alert-'.$type.'">'.$close.''.$content.'</div>';
    return $layout;
}
add_shortcode( 'alert', 'alert' );

/*/////////////////////////////////////////////////////////////////
 * NMBS Icons
 //////////////////////////////////////////////////////////////////

[icon name="icon-file" size="small" type="normal" color="#2A8FCE"]
[icon name="icon-file" size="medium" type="normal" color="#2A8FCE"]
[icon name="icon-file" size="big" type="normal" color="#2A8FCE"]
[icon name="icon-file" size="extra" type="normal" color="#2A8FCE"]
[icon name="icon-file" size="small" type="circle" color="#2A8FCE"]
[icon name="icon-file" size="medium" type="circle" color="#2A8FCE"]
[icon name="icon-file" size="big" type="circle" color="#2A8FCE"]
[icon name="icon-file" size="extra" type="circle" color="#2A8FCE"]

*/
function icon_function( $atts, $content = null ){
    $layout="";
        extract(shortcode_atts(array(
            'name'  => 'icon-file',
            'size'  => 'small',
            'type'  => 'normal',
            'color' => '#2A8FCE',
        ), $atts));
    if($type=='circle'){
        if($size=='small'){
            $layout =  '<span class="icon ' .$name. ' i-16 ' .$type. '" style="background:'.$color.'"></span>';
        }
        if($size=='medium'){
            $layout =  '<span class="icon ' .$name. ' i-32 ' .$type. '" style="background:'.$color.'"></span>';
        }
        if($size=='big'){
            $layout =  '<span class="icon ' .$name. ' i-64 ' .$type. '" style="background:'.$color.'"></span>';
        }
        if($size=='extra'){
            $layout =  '<span class="icon ' .$name. ' i-128 ' .$type. '" style="background:'.$color.'"></span>';
        }
    }
    if($type=='normal' || $type==''){
        if($size=='small'){
            $layout =  '<span class="icon ' .$name. ' i-16 ' .$type. '" style="color:'.$color.'"></span>';
        }
        if($size=='medium'){
            $layout =  '<span class="icon ' .$name. ' i-32 ' .$type. '" style="color:'.$color.'"></span>';
        }
        if($size=='big'){
            $layout =  '<span class="icon ' .$name. ' i-64 ' .$type. '" style="color:'.$color.'"></span>';
        }
        if($size=='extra'){
            $layout =  '<span class="icon ' .$name. ' i-128 ' .$type. '" style="color:'.$color.'"></span>';
        }
    }
    return $layout;
};
add_shortcode('icon', 'icon_function');