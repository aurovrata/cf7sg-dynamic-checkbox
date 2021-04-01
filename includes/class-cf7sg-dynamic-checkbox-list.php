<?php

/**
* Class extening teh Smart Grid dynamic lists abstract class.
*
* @since 4.10.0
*/
require_once plugin_dir_path( dirname(__DIR__) ) . 'cf7-grid-layout/includes/lists/class-cf7sg-dynamic-list.php';

class CF7SG_Dynamic_Checkbox_List extends CF7SG_Dynamic_list{

  public function __construct(){
    parent::__construct('dynamic_checkbox',__( 'dynamic-checkbox', 'cf7sg-dynamic-checkbox' ));
  }
  /**
  * define the style options for the dynamic list construct.
  * the stule unique slug will be inserted as class in the cf7 tag object, allowing the field styling.
  * @return Array an array of style-slug => style label.
  */
  public function admin_generator_tag_styles(){
    add_action('cf7sg_'.$this->tag_id.'_admin_tag_style-checkbox', array($this,'limit_checkboxes'));
    add_action('cf7sg_dynamic_list_tag_manager_options',array($this,'tree_view_or_images'));
    return array(
      'checkbox' => __('Checkbox fields','cf7sg-dynamic-checkbox'),
      'radio' => __('Radio fields','cf7sg-dynamic-checkbox'),
    );
  }
  public function limit_checkboxes(){
    ?>
    <span id="max-dynamic-checkbox" class="limit-options">
      <label>
        <input class="limit-check" type="checkbox" value="maxcheck"/>
        <?=__('Limit selections','cf7sg-dynamic-checkbox')?>
        <input type="text" disabled placeholder="3" value="" class="max-selection"/>
        <input type="hidden" value="" class="data-attribute" />
      </label>
    </span>
    <?php
  }

  /**
  * custom html + js script for select2 option.
  */
  public function tree_view_or_images(){
    /*
      the class $tag_id along with the style slug is used to buitl the input id attribute,
      so this input field is: $this->tag_id.'-'.'select2';
      Here an optional 'tags' class will be aded to the CF7 tag object when select2 style is chosen.
    */
    ?>
    <span id="tree-view" class="">
      <label>
        <input  type="checkbox" value="treeview"/>
        <?=__('Tree view','cf7sg-dynamic-checkbox')?>
      </label>
    </span>
    <span class="display-none" id="image-grid">
      <label>
        <input  type="checkbox" value="imagegrid"/>
        <?=__('Image grid','cf7sg-dynamic-checkbox')?>
      </label>
    </span>
    <script type="text/javascript">
    (function($){
      $('#dynamic-checkbox-tag-generator').change(':input',function(e){
        let $target = $(e.target);
        switch(true){
          case $target.is('.post-tab'):
            if($('#dynamic-checkbox-post-images').is(':checked')) $('#image-grid').show();
            break; //nothing to do.
          case $target.is('.source-tab'): //alternative source.
            $('#image-grid').hide().find(':input').prop('checked', false);
            break;
          case $target.is('#dynamic-checkbox-post-images'):
            if(e.target.checked) $('#image-grid').show();
            else $('#image-grid').hide().find(':input').prop('checked', false);
            break;
          case $target.is('.limit-check'):
            if(e.target.checked) $('#max-dynamic-checkbox .max-selection').prop('disabled',false);
            else $('#max-dynamic-checkbox .max-selection').prop('disabled',true);
            break;
          case $target.is('.list-style'):
            $('#max-dynamic-checkbox :input').prop('checked', false).val('');
            break;
          case $target.is('.max-selection'): //update hidden value.
            $('#max-dynamic-checkbox input.data-attribute').val('maxcheck:'+e.target.value);
            break;
        }
      });
    })(jQuery);
    </script>
    <?php
  }
  /**
	 * Register a [dynamic_display] shortcode with CF7.
	 * called by funciton above
	 * This function registers a callback function to expand the shortcode for the googleMap form fields.
	 * @since 1.0.0
   * @param Array $attrs array of attribute key=>value pairs to be included in the html element tag.
   * @param Array $options array of value=>label pairs  of options.
   * @param Array $option_attrs array of value=>attribute pairs  for each options, such as permalinks for post sources..
   * @param Boolean $is_multiselect if the field has multiple selection enabled..
   * @return String an html string representing the input field to a=be added to the field wrapper and into the form.
   */

  public function get_dynamic_html_field( $attrs, $options, $option_attrs, $is_multiselect, $selected){
    $attributes ='';
    foreach($attrs as $key=>$value){
      if('name'==$key && $is_multiselect) $value.='[]';
      $attributes .= ' '.$key.'="'.$value.'"';
    }
    $html = '<select value="'.$selected.'"'.$attributes.'>'.PHP_EOL;
    foreach($options as $value=>$label){
      $attributes ='';
      if(isset($option_attrs[$value])) $attributes = ' '.$option_attrs[$value];
      if($value==$selected) $attributes .=' selected="selected"';
      $html .= '<option value="'.$value.'"'.$attributes.'>'.$label.'</option>'.PHP_EOL;
    }
    $html .='</select>'.PHP_EOL;
    return $html;
  }

  /**
  * Function to get classes to be added to the form wrapper.
  * these classes will be passed in the resource enqueue action, allowing for specific js/css resources
  * to be queued up and loaded on the page where the form is being displayed.
  * @param WPCF7_FormTag cf7 tag object for the form field.
  * @param int $form_id cf7 fomr post ID..
  * @return Array an array of classes to be added to the form to which this tag belonggs to.
  */
  public function get_form_classes($tag, $form_id){
    /* Bookeeping, set up tagged select2 fields to filter newly added options in case Post My CF7 Form plugin is running */
    $class = $tag->get_class_option('');

    $form_classes = array();
    // if(strpos($class, 'select2')){
    //   $form_classes[] = 'has-select2';
    //   //track this field if user sets custom options.
    //   if(strpos($class, 'tags')){
    //     $tagged_fields = get_post_meta($form_id, '_cf7sg_select2_tagged_fields', true);
    //     if(empty($tagged_fields)){
    //       $tagged_fields = array();
    //     }
    //     if( !isset($tagged_fields[$tag->name]) ){
    //       $tagged_fields[$tag->name] = $source;
    //       update_post_meta($form_id, '_cf7sg_select2_tagged_fields',$tagged_fields);
    //     }
    //   }
    // }

    return $form_classes;
  }
  /**
  * Save new options for select2 with tags optoin enabled.
  */
  public function save_form_2_post($post_id, $form_id, $cf7_key, $post_fields, $post_meta_fields, $submitted_data){
    //nothing to do here.
  }
  public function register_styles($airplane){
    // $ff = '';
    // if(!defined('WP_DEBUG') || !WP_DEBUG){
    //   $ff = '.min';
    // }
    // $plugin_dir = plugin_dir_url( __DIR__ );
    // wp_register_style('jquery-nice-select-css',  "$plugin_dir../assets/jquery-nice-select/css/nice-select{$ff}.css", array(), '1.1.0', 'all' );
    // /** @since 3.2.1 use cloudflare for live sites */
    // if( $airplane || (defined('WP_DEBUG') && WP_DEBUG) ){
    //   wp_register_style('select2-style', "$plugin_dir../assets/select2/css/select2.min.css", array(), '4.0.13', 'all' );
    //   debug_msg($plugin_dir);
    // }else{
    //   wp_register_style('select2-style', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array(), '4.0.13','all');
    // }
  }
  public function register_scripts($airplane){
    /** @since 3.2.1 use cloudflare for live sites */
  //   $plugin_dir = plugin_dir_url( __DIR__ );
  //   if( $airplane || (defined('WP_DEBUG') && WP_DEBUG) ){
  //     wp_register_script('jquery-select2',  "$plugin_dir../assets/select2/js/select2.min.js", array( 'jquery' ), '4.0.13', true );
  //   }else{
  //     wp_register_script('jquery-select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array( 'jquery' ), '4.0.13', true );
  //   }
  //   wp_register_script('jquery-nice-select', "$plugin_dir../assets/jquery-nice-select/js/jquery.nice-select.min.js", array( 'jquery' ), '1.1.0', true );
  //
  //   //listen for script enqueue action.
  //   add_action('smart_grid_enqueue_scripts', function($cf7_key, $atts, $classes){
  //     //check for classes set in get_form_classes()method above.
  //     if(in_array('has-select2', $classes)){
  //       wp_enqueue_style('select2-style');
  //       wp_enqueue_script('jquery-select2');
  //     }
  //     if(in_array('has-nice-select', $classes)){
  //       wp_enqueue_style('jquery-nice-select-css');
  //       wp_enqueue_script('jquery-nice-select');
  //     }
  //   },10,3);
  }
}

if( !function_exists('cf7sg_create_dynamic_checkbox_tag') ){
  function cf7sg_create_dynamic_checkbox_tag(){
    //check if there is an existing instance in memory.
    $new_instance = CF7SG_Dynamic_Checkbox_List::get_instances('dynamic_checkbox');
    if(false === $new_instance) $new_instance =   new CF7SG_Dynamic_Checkbox_List();
    return $new_instance;
  }
}
add_action('cf7sg_register_dynamic_lists', 'cf7sg_create_dynamic_checkbox_tag');
