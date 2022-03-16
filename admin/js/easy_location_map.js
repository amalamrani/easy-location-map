/* javascript to add google map in page */

(function($) {

jQuery(document).ready(function(){

  var meta_image_frame;
  var media_attachment = '';

 
   // Runs when the image button is clicked.
    $('#easy_location_map_option_select_icon_marker').click(function(e){ 
 
 
        // Prevents the default action from occuring.
        e.preventDefault();
 
        // If the frame already exists, re-open it.
       if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
 
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({

            title: 'Choose Image',
            button: {text: 'Choose Image'}, 
                  
            library: { type: 'image' },
            multiple: false  // Set to true to allow multiple files to be selected
        });
 
        
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            media_attachment = meta_image_frame.state().get('selection').first().toJSON();

            // Sends the attachment URL to our custom image input field.
            $('#meta-image-iconmarker').val(media_attachment.url);
            
            var urlCurrentImage = $('#meta-image-iconmarker').val();            
                       
            if ( urlCurrentImage.length ){
                $('.meta-image-iconmarker-preview').attr("src", urlCurrentImage);
                $('.clearImageMarker').css('display','block');
                              
            }  


        });
 
        // Opens the media library frame.
        meta_image_frame.open();
       
    });


    $('.clearImageMarker').click(function(){

        $('#meta-image-iconmarker').val('');
        $('.meta-image-iconmarker-preview').removeAttr('src');
        $('.clearImageMarker').css('display','none');
    });


});

})(jQuery);



 
     

