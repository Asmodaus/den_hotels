;(function ($) {
    'use strict';
    $ ( document ).ready(function() { 
      $("#database_submit").click(function(e){ 
        e.preventDefault();
        var id=$('#form-id').val(); 
        if(id != 0 && id != ''){ 
            var url = database_admin_url.admin_url+'?page=ultimate-addons-db&form_id='+id; 
            window.location.href=url;
        }else{
            alert('Please select a form first');
        } 
      }); 
      $(".uacf7-db-view").click(function(e){ 
        e.preventDefault(); 
        var $this = $(this);
        var id = $(this).data("id"); 
        $this.html('<img src="'+database_admin_url.plugin_dir_url+'assets/images/loader.gif" alt="">');
        $.ajax({
            url: database_admin_url.ajaxurl,
            type: 'post',
            data: {
                action: 'uacf7_ajax_database_popup',
                id: id,
            },
            success: function (data) {  
              $("#db_view_wrap").html(data);  
              $(".uacf7_popup_preview").fadeIn(0);
              $this.html('View');
              $this.closest('tr').removeClass('unread');
             
            }
        }); 
      });
      $(".close").click(function() { 
        $(".uacf7_popup_preview").fadeOut(10);
        $("#db_view_wrap").html(''); 
      }); 
    });
})(jQuery);
