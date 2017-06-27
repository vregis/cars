$(document).ready(function() {
    if ($('.i-checks').length)
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

    
    if ($('.draggable_block').length) {
        var element = ".sortable-view";
        var handle = ".ibox-title";
        var connect = ".draggable_block";
        $(element).sortable(
            {
                handle: handle,
                connectWith: connect,
                tolerance: 'pointer',
                forcePlaceholderSize: true,
                opacity: 0.8,
                stop: function( ) {
                    var order = $(this).sortable("toArray", {attribute:'data-id'});
                    var model = $(this).parent('div').attr('data-model');

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        cache: false,
                        context: this,
                        url: 'http://'+location.hostname+'/'+model+'/setFullOrder',
                        data: {
                            order: order
                        },
                        success: function(data){
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "onclick": null,
                                "showDuration": "400",
                                "hideDuration": "500",
                                "timeOut": "2000",
                                "extendedTimeOut": "500",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };

                            toastr.success("", "Порядок сортировки сохранен!");
                        },
                        error: function(a,b,c) {
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "onclick": null,
                                "showDuration": "400",
                                "hideDuration": "500",
                                "timeOut": "2000",
                                "extendedTimeOut": "500",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };

                            toastr.error(a.responseText + b + c, "Ошибка сортировки!");
                        }
                    });
                }
            })
            .disableSelection();
    }


    /*if ($('.gritter_content'))
        setTimeout(function() {
            $.gritter.add({
                title: 'You have two new messages',
                text: 'Go to <a href="mailbox.html" class="text-warning">Mailbox</a> to see who wrote to you.<br/> Check the date and today\'s tasks.',
                time: 2000
            });
        }, 2000);*/
    
    if ($('.clockpicker').length)
        $('.clockpicker').clockpicker();
    
    enableChosen();
    enableCheckBoxInput();
    
    if ($('.chosen-select').length) 
        $('.chosen-select').chosen();
    
    if ($('.large-select').length)
        $('.large-select').select2({
            language: 'ru',
            ajax: {
                method: 'GET',
                dataType: 'json',
                delay: 250,
                context: this,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 3,
        });
    
    
    if ($('.form-horizontal'))
        $(".form-horizontal").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 3
                },
                url: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                min: {
                    required: true,
                    minlength: 6
                },
                max: {
                    required: true,
                    maxlength: 4
                }
            }
        });
    
    
    if ($('.delete-link').length)
        $('.delete-link').on('click', beDelete);


    if ($('.date').length)    
        $('.input-group.date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });


    if ($('.notification-message').length)
        $('.notification-message').mouseover(function() {
            var id = $(this).attr('data-id');

            $.ajax({
                type: "POST",
                dataType: "json",
                cache: false,
                context: this,
                url: 'http://'+location.hostname+'/notifications/setViewed?id='+id,
                data: {
                },
                success: function(data) {
                    amount = parseInt($('.new-notifications').text()) - 1;
                    if (amount < 1)
                        $('.new-notifications').hide();
                    else
                        $('.new-notifications').text(amount);                        
                    
                    $(this).removeClass('active');
                }
            });
            
            return true;
        });
    
    if ($('.new-notifications').length) {
        var amount = $('.new-notifications').text();
        
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        toastr.error("У вас "+plural(amount, "новое уведомление", "новых уведомления", "новых уведомлений")+".", "Обратите внимание!");
    }    
    
    
    
    if ($('.btn-submit').length)
        $('.btn-submit').on('click', function() {
            var form_id = $(this).attr('data-target-id');
            $('#'+form_id).submit();
            return false;
        });



    if ($('#field-country-id').length) {
        $('#field-country-id').change(function() {
            country_id = $(this).val();
            url =  $('#field-province-id').data('url');
            $.ajax({
                method: 'GET',
                dataType: 'html',
                context: this,
                url: url,
                data: {country_id: country_id},
                success: function(data) {
                    $('#field-province-id').html(data);  
                }
            });
        });
    }
    
});


function plural(number, one, two, five) {
    if ((number - number % 10) % 100 != 10) {
        if (number % 10 == 1)
            result = one;
        else if (number % 10 >= 2 && number % 10 <= 4) 
            result = two;
        else 
            result = five;
    } else 
        result = five;

    return number+' '+result;     
}


function gridUpdate(id, data) {
    enableCheckBoxInput();    
    enableChosen();
    
    if ($('.i-checks').length)
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
}

function enableCheckBoxInput() {
    $(".phaCheckBoxInput").on("click", function(e){            
        $.ajax({
            type: "POST",
            dataType: "html",
            cache: false,
            context: this,
            url: $(this).attr("data-url"),
            data: {
                item: $(this).attr("itemid"),
                checked: $(this).attr("checked")?0:1
            },
            success: function(data){
                //$("#"+$(this).attr("data-grid")).yiiGridView.update($(this).attr("data-grid"));
            }
        });
    });
}

function enableChosen() {
    if ($('.chosen-select').length) 
        $('.chosen-select').chosen({no_results_text:'К сожалению, ничего не найдено: '});
}

function beDelete() {
	if(!confirm('Вы уверены, что хотите удалить данный элемент?')) return false;
	var th = this;
	$.ajax({
		type: 'POST',
		url: jQuery(this).attr('href'),
		success: function(data) {
			location.reload();
		},
		error: function(a, b, c) {
			return alert(a.responseText);
		}
	});
	return false;
}