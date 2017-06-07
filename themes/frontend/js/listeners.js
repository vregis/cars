$(document).ready(function() {
    
    
    
    /*
     * Instant messages 
     */
    if ($('.im-content').length) {
        iframe_height = $(window).height() - $('.im-content').offset().top;
        $('.im-content iframe').height(iframe_height);
    }
    
    
    
    /*
     * Offer Photos Upload
     */
    if ($('.offer-photos-form input').length) {
        $('.offer-photos-form input').change(function() {
            $('.offer-photos-form').trigger('submit');
        });
    }
    
    
    
    /*
     * Styled file field
     */
    if ($('.file-styled').length) {
        $('.file-styled').on('click',function() {            
            $(this).blur();
            filefield = $(this).siblings('input[type="file"]');
            filefield.trigger('click');
            return false;
        });
        
        $('.file-styled-field').change(function() {
            btn = $(this).siblings('.file-styled');
            path = $(this).val();
            if (path.length) {
                btn.removeClass('btn-default').addClass('btn-success btn-solid');
                
                names = path.split('\\');
                names = names.reverse();
                
                if (names[0].length > 12)
                    name = names[0].substr(0, 6) + '...' + names[0].substr(-6, 6);
                else 
                    name = names[0];
                label = '<i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + name;
                btn.html(label);
            }
        });        
    }
    
    if ($('.file-ajax-upload').length) {
        $('.file-ajax-upload').change(function(e){
            success_container = $($(this).data('success-cont')).first();
            files = e.originalEvent.target.files;
            fileUpload($(this), files[0], false, success_container);            
        });
        
        $('.file-styled').on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
        }).on('dragover dragenter', function() {
            $(this).removeClass('btn-muted').addClass('btn-primary');
        }).on('dragleave dragend drop', function() {

        }).on('drop', function(e) {
            success_container = $($(this).data('success-cont')).first();
            droppedFiles = e.originalEvent.dataTransfer.files;
            obj = $(this).siblings('.file-ajax-upload');
            fileUpload(obj, droppedFiles[0], true, success_container);
        });
    }
    
    
    
    /*
     * Stories blocks
     */
    if ($('.article-featured-view p').length)
        setTimeout(alignStoriesBlocks, 500);
        
    
    
    
    /*
     * Mobile Menu Toggler
     */
    if ($('.toggle-menu').length) 
        $('.toggle-menu a').click(function() {
            if ($('.header-menu').hasClass('hidden-xs')) {
                $('.header-menu').addClass('animated fadeInDown');
                $('.header-menu').removeClass('hidden-xs');
            } else {
                $('.header-menu').addClass('fadeOutUp');
                setTimeout("$('.header-menu').addClass('hidden-xs').removeClass('animated fadeOutUp');", 1000);
            }
            
            return false;
        });
    
    
    
    
    /*
     * Header links
     */
    if ($('.header-dropdown-link').length) {
        $('.header-dropdown-link').click(function() {
            target_id = $(this).attr('data-target');
            
            $(this).parent('div').siblings('div').children('.header-dropdown').removeClass('open').slideUp(300);
            $('#'+target_id).addClass('open').slideToggle(300);
            
            $('#header-dropdown-litter').show();
            
            return false;
        });
                
        $('#header-dropdown-litter').click(function() {            
            $('#header-dropdown-litter').hide();
            
            $('.header-dropdown.open').removeClass('open').slideUp(300);
        });
    }
    
    
    
    /*
     * Affix for specified blocks
     */
    if ($('.affixed-block').length && $(window).width() > 750) {
        $('body').on('affix.bs.affix', function() {
            $('.affixed-block').css('width', $('.affixed-block').parent('div').width());
        });
        
        $('.affixed-block').affix({
                offset: {
                    top: 50,
                    bottom: 450
                }
            });            
    }
    
    
    
    
    /*
     * Home videos
     */
    /*if ($('.home-search-cover a').length) 
        $('.home-search-cover a').hover(function() {
            $(this).children('video').stop().animate({opacity: 1}, 300);
            $(this).parent('.home-search-cover').stop().animate({opacity: 1}, 300);
            $(this).children('video').get(0).play();
        }, function() {
            $(this).children('video').stop().animate({opacity: 0}, 300);
            $(this).parent('.home-search-cover').stop().animate({opacity: 0.5}, 300);
            $(this).children('video').get(0).pause();
        });
    
    */
    
    
    /*
     * Submit Button
     */
    if ($('.btn-submit').length) {
        $('.btn-submit').click(function() {
            if ($(this).parent('div.row').parent('form').length)
                $(this).parent('div.row').parent('form').submit();
            else if ($(this).parent('form').length)
                $(this).parent('form').submit();
            else if ($(this).attr('data-target').length){
                //roman
                //alert($(this).attr("class"));
                if($(this).attr("class")!="user-phone"){
                    $('#'+$(this).attr('data-target')).submit();
                }
            }
            
            return false;
        });
    }   
    
    if ($('#OfferOptions_title').length) {
        $('#OfferOptions_title').click(function() {
            if ($(this).val()=='Введите название')
                $(this).val('');
        });
    }
    
    
    /*
     * Comment Button
     */
    if ($('.btn-comment').length) {
        $('.client-review').on('click', '.btn-comment', function() {
            var comment_id = $(this).data('target');
            
            text = $('#textarea-'+comment_id).val();
            offer_id = $(this).data('offer');
            
            $.ajax({
                type: "POST",
                dataType: "html",
                cache: false,
                context: this,
                url: 'http://'+location.hostname+'/offers/offerComments/send',
                data: {
                    text: text,
                    parent_id: comment_id,
                    offer_id: offer_id
                },
                success: function(data){
                    $('.client-comment-'+comment_id).append(data);
                    $('#textarea-'+comment_id).val('');
                    $('#form-'+comment_id).collapse('hide');
                }
            });  
            
            return false;
        });
    }    
    /*
    *
    *Show phone number
    */

    if ($('#ao_button, #op_button').length) {
        $('#ao_button, #op_button').click(function() {

            var owner_id = $(this).attr('owner_id');
            if($(this).attr("class")!="user-phone"){
                $('#'+$(this).attr('data-target')).submit();
            }else{
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    cache: false,
                    context: this,
                    url: 'http://'+location.hostname+'/user/profile/phone',
                    data: {
                        owner_id: owner_id,
                    },
                    success: function(data){
                        if(data){
                            $('#op_button').html(data);
                            $('#ao_button').html(data);

                        }
                    }
                });
            }  
        });
    }


    /*
     * Get Additions
     */
    if ($('input[name="opt"]').length) {
        $('input[name="opt"]').on('ifChecked', null, function() {
            var main_option_id = $(this).val();
            
            if($(this).attr('use-paypal')=='1'){
            	$('#op_button').attr('class','btn btn-success btn-solid btn-block btn-submit');
                $('#op_button').attr('data-target','additional-options-form');
                $('#op_button').html('Order and Pay');
            	$('#ao_button').attr('class','btn btn-success btn-solid btn-block btn-submit');
                $('#ao_button').attr('data-target','additional-options-form');
                $('#ao_button').html('Order and Pay');
            	$('#sm_button').hide();
            }else{
            	$('#op_button').attr('class','user-phone');
                $('#op_button').html('Phone #');
                $('#ao_button').attr('class','user-phone');
                $('#ao_button').html('Phone #');
            	$('#sm_button').show();
            }

            $.ajax({
                type: "POST",
                dataType: "html",
                cache: false,
                context: this,
                url: 'http://'+location.hostname+'/offers/default/additions',
                data: {
                    main_option_id: main_option_id,
                },
                success: function(data){
                    if(data){
                        $('#hadd').show();
                        $('#additions').html(data);
                        $('#additions').show();
                        $('#additions div input').iCheck();
                    }else{
                        $('#hadd').hide();               
                        $('#additions').empty();
                        $('#additions').hide();                        
                    }
                    $(this).trigger('ifChanged');//recalculate price. 
                }
            });  
        });
    }

    if ($('#Orders_amount').length) {
        $('#Orders_amount').on('keyup',function() {
            price = 0;
            alter = 0;
            $('input.calcOptions:checked').each(function(i, d) {
                price1=parseFloat($(d).data('price'));
                if(!isNaN(price1))
                    price += price1;
                if ($(d).data('alter-price').length) alter += parseFloat($(d).data('alter-price'));
            });
            price*=$(this).val();
            if (alter > 0)
                result = '<span class="text-success">+ $'+price+'</span> / '+alter+' '+$('.options-result').data('currency');
            else
                result = '<span class="text-success">+ $'+price+'</span>';
            //alert(result);
            $('p.offer-price span.text-success').html(result);

        });
    }
    /*
     * Scroll Top Button
     */
    if ($('#get-top').length) {
        var scroll_top_offset = 0,
		scroll_top_duration = 700;
        
        //hide or show the "back to top" link
        $(window).scroll(function(){
            if ($(this).scrollTop() > scroll_top_offset)
                $('#get-top').removeClass('fadeOutDown').addClass('fadeInUp')
            else if ($('#get-top').hasClass('fadeInUp'))
                $('#get-top').removeClass('fadeInUp').addClass('fadeOutDown');
        });

        //smooth scroll to top
        $('#get-top').on('click', function(event){
            event.preventDefault();
            $('body,html').animate({
                scrollTop: 0 ,
                }, scroll_top_duration
            );
        });
    }
    
    
    
    /*
     * iCheck functionality
     */
    if ($('input').length) {
        $('input').iCheck({
            labelHover: true,
            cursor: true
        });
    }
    

    // if ($('#additional-options-form').length) {
    //     $('.iCheck-helper').on('click', function(event) {
    //         //alert('calcOptions length: '+$('input.calcOptions').length);
    //         price = 0;
    //         alter = 0;
    //         $('input.calcOptions:checked').each(function(i, d) {
    //             price += parseFloat($(d).data('price'));
    //             if ($(d).data('alter-price').length) alter += parseFloat($(d).data('alter-price'));
    //         });
            
    //         if (alter > 0)
    //             result = '<span class="text-success">+ $'+price+'</span> / '+alter+' '+$('.options-result').data('currency');
    //         else
    //             result = '<span class="text-success">+ $'+price+'</span>';
            
    //         $('.options-result').html(result);
    //     });
    // }


     if ($('#additional-options-form').length) {
        $('body').on('ifChanged','input', function(event) {
            price = 0;
            alter = 0;
            $('input.calcOptions:checked').each(function(i, d) {
                price += parseFloat($(d).data('price'));
                if ($(d).data('alter-price').length) alter += parseFloat($(d).data('alter-price'));
            });
            if (alter > 0)
                result = '<span class="text-success">+ $'+price+'</span> / '+alter+' '+$('.options-result').data('currency');
            else
                result = '<span class="text-success">+ $'+price+'</span>';
            
            $('.options-result').html(result);
            $('div.offer-price-large p.price-value').html(result);
        });
    }


    /*
     * Options Calculator
     */
    // if ($('#additional-options-form').length) {
    //     $('input.calcOptions').on('ifChanged', function(event) {
    //         //alert('calcOptions length: '+$('input.calcOptions').length);
    //         price = 0;
    //         alter = 0;
    //         $('input.calcOptions:checked').each(function(i, d) {
    //             price += parseFloat($(d).data('price'));
    //             if ($(d).data('alter-price').length) alter += parseFloat($(d).data('alter-price'));
    //         });
            
    //         if (alter > 0)
    //             result = '<span class="text-success">+ $'+price+'</span> / '+alter+' '+$('.options-result').data('currency');
    //         else
    //             result = '<span class="text-success">+ $'+price+'</span>';
            
    //         $('.options-result').html(result);
    //     });
    // }
    
    
    
    if ($('.phone-code').length)
        $('.phone-code').intlTelInput({
            preferredCountries: [ "il", "ua", "ru", "us" ]
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
            minimumResultsForSearch: 50,
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 3
        });
    
    
    
    /*
     * Styled select
     */
    if ($('.selectpicker').length) {
        $('.selectpicker').selectpicker({
            style: 'btn-muted',
            size: 4
        });
    }
    
    
    
    /*
     * Fancybox
     */
    if ($('.fancybox').length) 
        $('.fancybox').fancybox({padding: 0});
    if ($('.video-fancybox').length) 
        $('.video-fancybox').fancybox({
            padding: 0       
        });
    
    
    
    /*
     * Styled select
     */
    if ($('.nav-tabs[role=tablist]').length) {
        $('.nav-tabs[role=tablist] a').click(function (e) {            
            e.preventDefault();
            $(this).tab('show');
        });
        
        $('.nav-tabs[role=tablist]').each(function(i, d) {
            var hash = window.location.hash;
            
            $(d).children('li').children('a').each(function(j, a) {
                if (hash == $(a).attr('href'))
                    $(a).tab('show');
            });            
        });
    }  
    
    
    
    /*
     * Add to favourites
     */
    if ($('.offer-fav').length) {
        $('body').on('click', '.offer-fav', function() {
            id = $(this).attr('data-id');    
            url = $(this).attr('data-url');

            $.ajax({
                type: "POST",
                dataType: "json",
                cache: false,
                context: this,
                url: url,
                data: {
                    id: id
                },
                success: function(data){
                    $(this).toggleClass('fav-set');
                },
                error: function(a,b,c) {
                    
                }
            });
        
            return false;
        });
    }  
    
    
    
    /*
     * Mark review as helpful
     */
    if ($('.review-mark').length) {
        $('.review-mark').click(function() {
            id = $(this).attr('data-id');    
            url = $(this).attr('data-url');

            $.ajax({
                type: "POST",
                dataType: "json",
                cache: false,
                context: this,
                url: url,
                data: {
                    id: id
                },
                success: function(data){
                    $(this).toggleClass('marked');
                    if (data != '0')
                        $(this).children('.thumbs').children('.marks-count').text(data);
                    else
                        $(this).children('.thumbs').children('.marks-count').text('');
                },
                error: function(a,b,c) {
                }
            });
        
            return false;
        });
    }  
    
    
    
    /*
     * Toggle all/negative reviews
     */
    if ($('.reviews-filter a').length) {
        $('.reviews-filter a').click(function() {
            if ($(this).attr('data-type') == 'negative') {
                $('.client-review').each(function(i, d) {
                    if (parseInt($(d).attr('data-rating')) >= 4)
                        $(d).fadeOut(500);
                });
            } else {                
                $('.client-review').each(function(i, d) {
                    if (parseInt($(d).attr('data-rating')) >= 4)
                        $(d).fadeIn(500);
                });
            }
        
            return false;
        });
    }  
    
    
    
    /*
     * Smooth scroll
     */
    if ($('.smooth-scroll').length) {
        $('.smooth-scroll').click(function() {
            id = $(this).attr('data-target');
        
            top_pos = $('#'+id).offset().top - 50;
            
            //smooth scroll to target
            $('body,html').animate({scrollTop: top_pos}, 300);

            return false;
        });
    }  
    
    
    
    /*
     * Smooth scroll + Tab open
     */
    if ($('.smooth-tab').length) {
        $('.smooth-tab').click(function() {
            id = $(this).data('target');
            tab = $(this).data('tab');
        
            top_pos = $('#'+id).offset().top - 50;
            
            //smooth scroll to target
            $('body,html').animate({scrollTop: top_pos}, 300);
            
            //open tab
            $('#'+id+' a[href="#'+tab+'"]').tab('show');

            return false;
        });
    }  
    
    
    if ($('.draggable_block').length) {
        var element = ".sortable-view";
        var handle = ".handle-draggable";
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
                                "progressBar": true,
                                "positionClass": "toast-bottom-right",
                                "onclick": null,
                                "showDuration": "400",
                                "hideDuration": "500",
                                "timeOut": "2000",
                                "extendedTimeOut": "500",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut",
                                "preventDuplicates ": true
                            };

                            toastr.success("", "Порядок сортировки сохранен!");
                        },
                        error: function(a,b,c) {
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "progressBar": true,
                                "positionClass": "toast-bottom-right",
                                "onclick": null,
                                "showDuration": "400",
                                "hideDuration": "500",
                                "timeOut": "2000",
                                "extendedTimeOut": "500",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut",
                                "preventDuplicates ": true
                            };

                            toastr.error(a.responseText + b + c, "Ошибка сортировки!");
                        }
                    });
                }
            })
            .disableSelection();
    }
    
    
    
    /*
     * Styled file field for profile
     */
    if ($('.profile-image').length)         
        $('.profile-image').on('click',function() {            
            $(this).blur();
            filefield = $(this).siblings('input[type="file"]');
            filefield.trigger('click');
            return false;
        });
    if ($('.profile-image-file').length)         
        $('.profile-image-file').on('change',function(e) {
            success_container = $($(this).data('success-cont')).first();
            files = e.originalEvent.target.files;
            fileUpload($(this), files[0], false, success_container);
            /*
            if ($(this).val().length > 0)
                $(this).parent('div').parent('.photo-delete-panel').addClass('selected');
            else
                $(this).parent('div').parent('.photo-delete-panel').removeClass('selected');
            */
            
            return false;
        });
        
    
    
    /*
     * Delete on grid
     */
    if ($('.delete-link').length)
        $('.delete-link').on('click', beDelete);
    
    
    
    /*
     * Switch day schedule
     */
    if ($('.table-calendar').length) {
        $('.table-calendar td').click(function() {
            $('.table-calendar td.selected').removeClass('selected');
            $(this).addClass('selected');
            
            date = $(this).data('date');
            url = $('.daily-schedule').data('url');
            
            if (date.length)
                $.ajax({
                    method: 'GET',
                    dataType: 'html',
                    context: this,
                    url: url,
                    data: {
                        date: date
                    },
                    success: function(data) {
                        $('.daily-schedule').html(data);
                    }
                });
        });
        
        $('body').on('click', '.daily-schedule a.delete-link', function() {
            url = $(this).attr('href');
            
            $.ajax({
                method: 'POST',
                dataType: 'html',
                context: this,
                url: url,
                data: {
                },
                success: function(data) {
                    location.reload();
                }
            });
            
            return false;
        });
    }
    
    
    
    /*
     * Profile stats
     */
    if ($('#myChart').length) {
        var ctx = $("#myChart");
        
        chartData = Array();
        chartData.push(ctx.data('personal-info'));
        chartData.push(ctx.data('social'));
        chartData.push(ctx.data('photos'));
        chartData.push(ctx.data('documents'));
        chartData.push(ctx.data('phones'));
        chartData.push(ctx.data('account'));
        
        var myChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ["Personal Info", "Social", "Photos", "Documents", "Phones", 'Account'],
                datasets: [
                    {
                        backgroundColor: "rgba(27,173,88,0.2)",
                        borderColor: "rgba(27,173,88,1)",
                        pointBackgroundColor: "rgba(27,173,88,1)",
                        pointBorderColor: "#fff",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(27,173,88,1)",
                        data: chartData
                    }
                ],
            },
            options: {
                legend: {display: false},
                tooltips: {enabled: false},
                scale: {
                    ticks: {
                        maxTicksLimit: 5
                    }
                }
            },
            hover: {
                onHover: function() {
                    alert(123);
                }
            }
        });
    }
        
});



function gridUpdate(id, data) {
}



function beDelete() {
	var th = this;
    confirm_text = $(this).data('confirm');
    if (!confirm_text.length)
        confirm_text = 'Вы уверены, что хотите удалить данный элемент?';
    
	if(!confirm(confirm_text+' Da?')) return false;
    
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



function alignStoriesBlocks() {
    $('.article-featured-view p').each(function(i, d) {            
        var link_height = $(this).children('a').height();
        var parent_height = $(this).parent('div').height();
        var padding = Math.round((parent_height - link_height) / 2);

        console.log(link_height+'|'+parent_height+'|'+padding);

        $(d).css('paddingTop', padding);
    });
}

function fileUpload(obj, file, is_drag, success_container) {
    name = file.name;
    size = file.size;
    type = file.type;

    if (file.name.length < 1) {
    }
    else if (file.size > 5000000) { // 5MB
        alert("The file is too big");
    }
    else { 
        form_id = obj.data('form');
        url = obj.data('url');

        var formData = new FormData($('#'+form_id)[0]);
        if (is_drag) {
            formData.append(obj.attr('name'), file);
        }            

        $.ajax({
            url: url,
            type: 'POST',
            context: obj,
            xhr: function() {  // custom xhr
                myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // if upload property exists
                    //myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // progressbar
                }
                return myXhr;
            },
            // Ajax events
            success: completeHandler = function(data) {                
                if (success_container.length)
                    success_container.attr('src', data);

                obj.val('');
                obj.siblings('.file-styled').attr('class', 'btn btn-default file-styled').html('<i class="fa fa-download fa-before"></i>&nbsp;&nbsp;&nbsp;Выберите файл...');
            },
            error: errorHandler = function(a, b, c) {
                alert("Something went wrong:" + a.responseText);
            },
            // Form data
            data: formData,
            // Options to tell jQuery not to process data or worry about the content-type
            cache: false,
            contentType: false,
            processData: false
        }, 'json');
    }
}