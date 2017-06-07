$(document).ready(function() {
    
    
    /*
     * Login form
     */
    if ($('.login-button').length) {
        $('.login-button').click(function() {
            obj = $('.login-modal').first();
            obj.modal();   
            
            return false;
        });
    }
    
    
    
    /*
     * Popup windows
     */
    if ($('.popup-default').length) {
        obj = $('.popup-default').first();
        setTimeout('$(\'.popup-default\').first().modal();', 1000);
        
        if ($('.popup-default').first().data('delay').length)
            setTimeout('$(\'.popup-default\').first().modal("hide");', parseInt($('.popup-default').first().data('delay'))*1000);
    }
        
});