(function ($) {
  Drupal.behaviors.tommiblog = {
    attach: function (context, settings) {
    
  // Open and close the main mobile menu
    $('#block-mobilemenuswitcher').click(function(){
       $('body').toggleClass('mobile-menu-open');
       
    });
    $('#block-mobilemenuswitcher-2').click(function(){
       $('body').toggleClass('mobile-menu-open');
       
    });

       
    } // end of attach function
  };
})(jQuery);