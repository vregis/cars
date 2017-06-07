$(document).ready(function() {
    
    
    dialog_height = $(window).height() - $('form').height();
    $('#dialog-box').height(dialog_height);
    
    
    /*
     * Scroll to form
     */
    if ($('#dialog-box').length) {
        $('#dialog-box').animate({
            scrollTop: 500000
            }, 0
        );
    }
    
    
    
    /*
     * updating dialog
     */
    setInterval(updateDialog, 3000);
    
    
    
    /*
     * Message seen
     */
    if ($('.message-container.unseen').length) {
        $('#dialog-box').on('mouseover', '.message-container.unseen', function() {
            $.ajax({
                type: "GET",
                dataType: "html",
                cache: false,
                context: this,
                url: 'http://'+location.hostname+'/user/privateMessages/setSeen',
                data: {
                    id: $(this).data('id')
                },
                success: function(data){
                    $(this).removeClass('unseen');
                }
            });            
        });
    }
    
    
    
    /*
     * Message seen
     */
    if ($('.btn-success').length) {
        $('.btn-success').click(function() {
            id = $(this).data('id');
            text = $('#dialog-text').val();
            
            $.ajax({
                type: "POST",
                dataType: "html",
                cache: false,
                context: this,
                url: 'http://'+location.hostname+'/user/privateMessages/add?id='+id,
                data: {
                    text: text
                },
                success: function(data){
                    $('#dialog-text').val('');
                    updateDialog();
                },
                error: function(a, b, c) {
                    alert(a.responseText);
                }
            }); 
            
            return false;
        });
    }
    
});


function updateDialog() {
    var id = $('.btn-success').data('id');  
    
    //update dialog window
    $.ajax({
        type: "POST",
        dataType: "html",
        cache: false,
        context: this,
        url: 'http://'+location.hostname+'/user/privateMessages/ajaxList?id='+id,
        data: {
        },
        success: function(data) {
            $('#dialog-box').html(data);
            
            $('#dialog-box').animate({
                scrollTop: 500000
                }, 0
            );
        },
        error: function(a, b, c) {
            alert(a.responseText);
        }
    });       
    
    //update new messages
    $.ajax({
        type: "POST",
        dataType: "json",
        cache: false,
        context: this,
        url: 'http://'+location.hostname+'/user/privateMessages/getNewMessages',
        data: {
            id: id
        },
        success: function(data) {            
            $('.pm-label-all').text(data.all);
            $('.pm-label').each(function(i, d) {
                if ($(d).data('id') == id) {
                    if (data.actual > 0)
                        $(d).text('+'+data.actual);
                    else
                        $(d).remove();
                }
            });
        },
        error: function(a, b, c) {
            alert(a.responseText);
        }
    }); 
}
