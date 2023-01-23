;(function ($) {
    'use strict';
    $ ( document ).ready(function() {  
        wp.codeEditor.initialize($('#custom_pdf_css'), pdf_settings);

    });

    $('#upload_image_button').click(function(e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#upload_image').val(image_url);
        }).on('close',function() {
            var data = {
                action: 'reset_upload_dir'
            };
            jQuery.post(ajaxurl, data, function(response) {
                alert('Got this from the server: ' + response);
            });
        });
    });
    $('#upload_pdf_image_button').click(function(e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#pdf_bg_upload_image').val(image_url);
        }).on('close',function() {
            var data = {
                action: 'reset_upload_dir'
            };
            jQuery.post(ajaxurl, data, function(response) {
                alert('Got this from the server: ' + response);
            });
        });
    });

    // var custom_uploader;
    // jQuery('#upload_image_button').click(function(e) {
 
    //     e.preventDefault(); 
        
    //     //If the uploader object has already been created, reopen the dialog
    //     if (custom_uploader) {
    //         custom_uploader.open();
    //         return;
    //     }

    //     //Extend the wp.media object
    //     custom_uploader = wp.media.frames.file_frame = wp.media({
    //         title: Data.title,
    //         button: {
    //             text: Data.textebutton
    //         },
    //         multiple: false
    //     });

    //     //When a file is selected, grab the URL and set it as the text field's value
    //     custom_uploader.on('select', function() {
    //         attachment = custom_uploader.state().get('selection').first().toJSON();
    //         jQuery('#upload_image').val(attachment.url);
    //     });

    //     //Open the uploader dialog
    //     custom_uploader.open();

    // });

})(jQuery);
