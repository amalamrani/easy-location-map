<?php
/*
* Plugin Name: Easy Location Map
* Description: Add google map in your site by adding coordinates and your contact information from admin panel, and choose between different styles. You can also choose the marker icon for the map
* Plugin URI: https://amrani.es/wp-plugins/easy-map.php
* Author: Amal Amrani. 
* Author URI:   https://amrani.es
* Version: 1.2
* License:      GPLv2 or later
* License URI:  https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:  easy_location_map
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'easy_location_map_class' ) ) {
    
    class easy_location_map_class{
        
        /**
        * Construct the plugin object
        */
        
        public function __construct(){

            add_action('admin_menu',  array( &$this,'easy_location_map_menu') );
            add_action( 'admin_init',  array( &$this,'register_mysettings_easy_location_map')); 

            add_action( 'admin_enqueue_scripts',  array( &$this,'easy_location_map_add_stylesheet_scripts') );

            add_shortcode( 'google_map', array( &$this, 'easy_location_map_add_map') );
        }

        public function easy_location_map_menu(){
            add_menu_page( 'Easy Location Map', 'Easy Location Map', 'manage_options', 'easy_location_map', array(&$this,'easy_location_map_init'), 'dashicons-location-alt');
           
        }

        public function easy_location_map_init(){

        echo "<h1 class='title_plugin'>".esc_html__('Easy Location Map ', 'easy_location_map' )." </h1>";

        echo '<div class="how-use-map">You can add the map in text editor as: <strong>[google_map]</strong> Or include it in template like:  <strong>echo do_shortcode("[google_map]");</strong> </div>';

       
        $info_contact_options = get_option('easy_location_map_option');

        if ( false === $info_contact_options ) { 
           $info_contact_options = array(
                'address' => '',
                'city' => '',
                'country' => '',
                'email' => '',
                'phone'  => '',
                'marker' => '',
                'color' => 'blackStyle',
                'coordinateLat' => '',
                'coordinateLng' => '',
                'googleApiKey' => '',
                
            );

            add_option( 'easy_location_map_option', $info_contact_options );                       
        }
        else{
          
            // clean white spaces coordinates
            if ( isset ($info_contact_options['coordinateLat']) )  $info_contact_options['coordinateLat'] = preg_replace('/\s+/', '', $info_contact_options['coordinateLat']);
            if ( isset ($info_contact_options['coordinateLng']) )  $info_contact_options['coordinateLng'] = preg_replace('/\s+/', '', $info_contact_options['coordinateLng']);
            
        }   
        ?>
        <div class="wrap">

            

            <?php settings_errors( 'easy_location_map_option_settings_errors' ); ?>

            <form id="easy_location_map_option" action="options.php" method="post" >

                <?php
                   
                     settings_fields('easy_location_map_option');// option group name
                     do_settings_sections('easy_location_map');// page  name
                ?>
                                  
                <div class="item">
                    <label for="easy_location_map_option[address]" ><?php _e('Your address', 'easy_location_map' ); ?></label>
                    <input type="text" name="easy_location_map_option[address]" placeholder="<?php _e('Enter your address', 'easy_location_map' ); ?>" value="<?php  echo $info_contact_options['address'] ?>" />
                </div>

                <div class="item">
                    <label for="easy_location_map_option[city]" ><?php _e('Your city', 'easy_location_map' ); ?></label>
                    <input type="text" name="easy_location_map_option[city]" placeholder="<?php _e('Enter your city', 'easy_location_map' ); ?>" value="<?php  echo $info_contact_options['city'] ?>" />
                </div>

                <div class="item">
                    <label for="easy_location_map_option[country]" ><?php _e('Your country', 'easy_location_map' ); ?></label>
                    <input type="text" name="easy_location_map_option[country]" placeholder="<?php _e('Enter your country', 'easy_location_map' ); ?>" value="<?php  echo $info_contact_options['country'] ?>" />
                </div>

                <div class="item">
                    <label for="easy_location_map_option[email]" ><?php _e('Your email', 'easy_location_map' ); ?></label>
                    <input type="email" name="easy_location_map_option[email]" placeholder="<?php _e('Enter your email', 'easy_location_map' ); ?>" value="<?php  echo $info_contact_options['email'] ?>" />
                </div>

                <div class="item">
                    <label for="easy_location_map_option[phone]" ><?php _e('Your phone', 'easy_location_map' ); ?></label>
                    <input type="text" name="easy_location_map_option[phone]" placeholder="<?php _e('Enter your phone number', 'easy_location_map' ); ?>" value="<?php  echo $info_contact_options['phone'] ?>" />
                </div>

                <div class="item">
                    <label for="easy_location_map_option[coordinateLat]"><?php _e('Google maps Lat coordinate', 'easy_location_map' ); ?></label>
                    <input type="text" name="easy_location_map_option[coordinateLat]" placeholder="<?php _e('Enter latitude coordinate here', 'easy_location_map' ); ?>"  
                    value="<?php  echo  $info_contact_options['coordinateLat'] ?>" />
                    <br /><span class="text-help"><?php _e('for example: 37.1795575', 'easy_location_map' ); ?></span>
                </div>
                 <div class="item">
                    <label for="easy_location_map_option[coordinateLng]"><?php _e('Google maps Lng coordinate', 'easy_location_map' ); ?></label>
                    <input type="text" name="easy_location_map_option[coordinateLng]" placeholder="<?php _e('Enter longitude coordinate here', 'easy_location_map' ); ?>"  
                    value="<?php  echo  $info_contact_options['coordinateLng'] ?>" />
                    <br /><span class="text-help"><?php _e('for example : -3.5995972', 'easy_location_map' ); ?></span>
                </div>

                <div class="item">
                    <span ><?php _e('Choose Your map color', 'easy_location_map' ); ?></span>
                    <input type="radio" name="easy_location_map_option[color]"  value="grayStyle"  <?php echo ($info_contact_options['color'] == 'grayStyle') ? 'checked' : ''  ?> /><label id="grayStyle">Gray</label>
                    <input type="radio" name="easy_location_map_option[color]"  value="aquaStyle2" <?php echo ($info_contact_options['color'] == 'aquaStyle2') ? 'checked' : ''  ?>  /><label id="aquaStyle">Aqua</label>
                    <input type="radio" name="easy_location_map_option[color]"  value="blackStyle" <?php echo ($info_contact_options['color'] == 'blackStyle') ? 'checked' : ''  ?> /><label id="blackStyle">Black</label>

                    
                </div>

                <div class="item">
                    <label for="easy_location_map_option[googleApiKey]"><?php _e('Google Api Key', 'easy_location_map' ); ?></label>
                    <input type="text" name="easy_location_map_option[googleApiKey]" placeholder="<?php _e('Enter your google Api Key here', 'easy_location_map' ); ?>"  
                    value="<?php  echo  $info_contact_options['googleApiKey'] ?>" />
                    <br /><span class="text-help"><?php _e(' <a href="https://developers.google.com/maps/documentation/javascript/get-api-key"> get your google Api Key</a>', 'easy_location_map' ); ?></span>
                </div>

                 <div class="item">
                    <label for="easy_location_map_option[marker]" ><?php _e('Chose your Map Icon Marker ', 'easy_location_map' ); ?></label>                    
                     <input type="button" id="easy_location_map_option_select_icon_marker" value="<?php _e('Select your Icon Marker Image ', 'easy_location_map' ) ?>" />
                        <input type="hidden" name="easy_location_map_option[marker]"  id="meta-image-iconmarker"  value="<?php  echo  $info_contact_options['marker'] ?>" />
                        <img class="meta-image-iconmarker-preview" src="<?php  echo  $info_contact_options['marker'] ?>" />
                        <div class="clearImageMarker" style="<?php echo (isset($info_contact_options['marker']) && $info_contact_options['marker'] != '' ) ? 'display:block;': 'display:none;' ?>"> <?php _e( 'Remove this Image Marker', 'easy_location_map' )?></div>
                
                </div>

                <p class="submit">
                     <?php submit_button(); ?>                                 
                </p>

            </form>
        </div>

        <?php        
        }

        public function register_mysettings_easy_location_map(){  
        
        $option_name = 'easy_location_map_option';          
        register_setting( 'easy_location_map_option', $option_name );  
     
        }
        public function easy_location_map_add_stylesheet_scripts() {       
            wp_enqueue_media();
            wp_enqueue_script('easy_location_map_option_js',  plugin_dir_url( __FILE__ ).'/admin/js/easy_location_map.js', array('jquery')); //, '1.0', true            
            wp_enqueue_style( 'easy_location_map_option_style', plugin_dir_url( __FILE__ ).'/admin/css/styles.css' );
           
        }

        // [google_map]
        /*
         function to add our google map into page, from the editor.
         just include in the editor the tag [google_map] and your map will appear in the page
        */
        public function easy_location_map_add_map( $atts ) {
       
            
        $info_contact_options = get_option('easy_location_map_option');
        $lat='';
        $lng= '';
        $marker= '';

        $phone = '';
        $address= '';
        $colorMap = '';
       
        
        if ( isset($info_contact_options['coordinateLat']) ) 
            $lat = preg_replace('/\s+/', '', $info_contact_options['coordinateLat']) ;

        if ( isset($info_contact_options['coordinateLng']) ) 
            $lng = preg_replace('/\s+/', '', $info_contact_options['coordinateLng']) ;

        if ( isset($info_contact_options['marker']) ) $marker = $info_contact_options['marker'];

        if ( isset($info_contact_options['color']) ) $colorMap = $info_contact_options['color'];

        if( isset($info_contact_options['address']) ){ 
            $address = $info_contact_options['address'];

            if( isset($info_contact_options['city'] ) ) $address =  $address.' '.$info_contact_options['city'];

            if( isset($info_contact_options['country'] ) ) $address =  $address.'<br />'.$info_contact_options['country'];        
        }

        if( isset($info_contact_options['phone']) ) $phone= $info_contact_options['phone'];


        $output = '<input type="hidden" id="coordinatelat-values-from-info-contact" value="'.$lat.'" />
        
      <input type="hidden" id="coordinatelng-values-from-info-contact" value="'.$lng.'" />

      <input type="hidden" id="meta-image-iconmarker-url" value="'.$marker.'" />
      <input type="hidden" id="color-map-location" value="'.$colorMap.'" />
      <input type="hidden" id="address" value="'.$address.'" />
      <input type="hidden" id="phone" value="'.$phone.'" />
      <input type="hidden" id="site-name" value="'.get_bloginfo('name').'" />';


        if( isset( $info_contact_options['googleApiKey']) && $info_contact_options['googleApiKey'] != '' && $info_contact_options['coordinateLat']!= '' && $info_contact_options['coordinateLng'] != '') :  
            $output .= '<div id="google-map" style=" min-width: 300px;
        max-height: 600px;
        margin-top: 1.5em;
        height: 65vh;
        width: 100%;
        position: relative;
        z-index: 9;"></div>';  

            $url_plugin = plugins_url('',__FILE__); 
            if( is_multisite() ) $url_plugin = network_home_url().'wp-content/plugins/'.plugin_basename( __DIR__ );

        $output .= '<script type="text/javascript" src="'.$url_plugin. '/admin/js/init-location-map-function.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key='.$info_contact_options['googleApiKey'].'&libraries=geometry,places&callback=initMap" type="text/javascript"></script>';

        return $output;  
       
        endif; 
        }

    }    

    
} //CLASS   

try{
    $google_maps = new easy_location_map_class();

}catch(Exception $exception){
              
    echo $exception->getMessage();

}    

?>