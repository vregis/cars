$(document).ready(function() {
    
    
    
    /*
     * Basic Datepicker
     */
    if ($('.basic-datepicker').length)    
        $('.basic-datepicker').datetimepicker({  
            format: 'YYYY-MM-DD',
            locale: 'ru',
            viewMode: 'years',
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-calendar-check-o',
                clear: 'fa fa-trash-o',
                close: 'fa fa-close'
            }
        });
    
    
        
    if ($('.clockpicker').length)
        $('.clockpicker').clockpicker();



    if ($('.datepicker').length)    
        $('.datepicker').datetimepicker({  
            format: 'YYYY-MM-DD',
            locale: 'ru',
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-calendar-check-o',
                clear: 'fa fa-trash-o',
                close: 'fa fa-close'
            }
        });
    
    
    
    /*
     * Datepickers
     */
    language = $('body').data('language');
    datepickerOptions = {
        language: language,
        startOfWeek: 'monday',
        separator : ' ~ ',
        format: 'YYYY-MM-DD HH:mm',
        autoClose: false,
        showTopbar: false,
        time: {
            enabled: true
        },
        showShortcuts: true,
        shortcuts :
        {
            'next-days': [3,5,7],
            'next': ['week','month','year']
        }
    };
    datepickerSingleOptions = datepickerOptions;
    datepickerSingleOptions.singleDate = false;
    
    
    if ($('.daterangepicker').length) 
        $('.daterangepicker').dateRangePicker(datepickerOptions);
    
    
    if ($('#order-dates').length) 
        $('#order-dates').dateRangePicker(datepickerOptions).bind('datepicker-change',function(event, obj) {
            var dates = $('#order-dates').val();
            var offer_id = $('#order-dates').data('offer-id');
            
            $('#order-dates-result').html('<i class="fa fa-refresh fa-spin text-muted"></i>');
            
            $.ajax({
                type: "POST",
                dataType: "html",
                cache: false,
                context: this,
                url: 'http://'+location.hostname+'/offers/default/checkDates',
                data: {
                    dates: dates,
                    offer_id: offer_id
                },
                success: function(data) {
                    if (data.length) {
                        $('#order-dates-result').html('<i class="fa fa-times text-danger"></i>');
                        
                        $('#order-dates-container').popover({
                            content: data,
                            html: true,
                            title: 'Unavailable dates',
                            trigger: 'manual',
                            placement: 'right'
                        }).popover('show');
                    } else {
                        $('#order-dates-container').popover('hide');
                        $('#order-dates-result').html('<i class="fa fa-check text-success"></i>');
                    }
                },
                error: function(a, b, c) {
                    alert(a.responseText);
                }
            }); 
        });


    if ($('.date').length)    
        $('.date input').dateRangePicker(datepickerSingleOptions);
        
    
    /*
     * Add blocked period button
     */
    if ($('.btn-add-block').length) {
        $('.btn-add-block').dateRangePicker(datepickerOptions).bind('datepicker-change',function(event, obj) {
            url =  $('.btn-add-block').data('url');
            
            $.ajax({
                method: 'GET',
                dataType: 'html',
                context: this,
                url: url,
                data: {
                    since: moment(obj.date1).format('YYYY-MM-DD HH:mm'),
                    for: moment(obj.date2).format('YYYY-MM-DD HH:mm')
                },
                success: function(data) {
                    location.reload();
                }
            });
        });
        
        $('.btn-add-block').click(function() {
            
            return false;
        });
    }
        
});