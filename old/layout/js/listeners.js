$(document).ready(function() {
    
    
    
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
            
            $(this).parent('div').siblings('div').children('.header-dropdown').slideUp(300);
            $('#'+target_id).slideToggle(300);
            
            return false;
        });
                
        $('.header-dropdown-link').blur(function() {
            target_id = $(this).attr('data-target');
            $('#'+target_id).slideToggle(300);
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
     * Home search input
     */
    if ($('#home-search-input').length) {
        $('#home-search-input').keyup(function() {
            text = $(this).val();
            if (text.length > 2) {
                $('#home-search-results').hide();

                var result = Array();

                /*$.ajax({
                    type: "POST",
                    dataType: "json",
                    cache: false,
                    context: this,
                    url: 'http://'+location.hostname+'/site/checkSearch',
                    data: {
                        text: text
                    },
                    success: function(data){
                        result = data;
                    },
                    error: function(a,b,c) {

                    }
                });*/

                $('#home-search-results').show();
            } else {
                $('#home-search-results').hide();
            }
        });
        
        $('#home-search-input').blur(function() {
            $('#home-search-results').hide();
        });
    }
    
    
    
    
    /*
     * Home videos
     */
    if ($('.home-search-cover video').length) 
        $('.home-search-cover video').hover(function() {
            $(this).stop().animate({opacity: 1}, 300);
            $(this).parent('.home-search-cover').animate({opacity: 1}, 300);
            $(this).get(0).play();
        }, function() {
            $(this).stop().animate({opacity: 0}, 300);
            $(this).parent('.home-search-cover').animate({opacity: 0.5}, 300);
            $(this).get(0).pause();
        });
    
    
    
    /*
     * Star rating
     */
    if ($('.star-rating').length) {
        $('.star-rating').each(function(i, d) {
            rating = parseInt($(d).children('li.star-result').children('input').val());
            
            displayStarRating($(d), rating);
        });
        
        $('.star-rating li').hover(function() {
            displayStarRating($(this), null);
        }, function() {
            rating = parseInt($(this).siblings('li.star-result').children('input').val());
            displayStarRating($(this).parent('ul'), rating);
        });
        
        $('.star-rating li').click(function() {
            updateStarRating($(this), null);
        });
    }
    
    
    
    /*
     * Datepickers
     */
    if ($('.daterangepicker').length) {
        $('.daterangepicker').daterangepicker({            
            startDate: moment(),
            endDate: moment().add(29, 'days'),
            buttonClasses: ['btn', 'btn-daterange'],
            opens: 'left',
            dateLimit: { days: 60 },
            autoApply: true,
            autoUpdateInput: true,
            applyClass: 'btn-success',
            cancelClass: 'btn-default',
            ranges: {
                'Today': [moment(), moment()],
                'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                'Next 7 Days': [moment().add(6, 'days'), moment()],
                'Next 30 Days': [moment().add(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')]
            },
            locale: {
                format: 'YYYY-MM-DD',
                separator: ' ~ ',
                applyLabel: 'Submit',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }

        }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        });
    }
    
    
    
    /*
     * Submit Button
     */
    if ($('.btn-submit').length) {
        $('.btn-submit').click(function() {
            if ($(this).parent('div.row').parent('form').length)
                $(this).parent('div.row').parent('form').submit();
            else if ($(this).parent('form').length)
                $(this).parent('form').submit();
            else if ($(this).attr('data-target').length)
                $('#'+$(this).attr('data-target')).submit();
            
            return false;
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
     * Map Positioning
     */
    if ($('#search-map').length && $(window).width() > 750) {        
        $('#search-results-cover').css('min-height', $(window).height()-50);
        $('#search-map').height($(window).height());
        $('#search-map').children('iframe').height($(window).height());        
        
        map_bottom = $('#search-map').offset().top + $(window).height();
        footer_top = $('#subscription-footer').offset().top;
        var stop_offset = $('#search-map').offset().top + $('#search-map').height();
        
        if (map_bottom < footer_top) {
            $(window).scroll(function() {
                offset = $(window).height() + $(window).scrollTop();
                map_bottom = $('#search-map').offset().top + $('#search-map').height();
                results_bottom = $('#search-results-list').offset().top + $('#search-results-list').height();
                footer_top = $('#subscription-footer').offset().top;

                if (offset >= footer_top && !$('#search-map').hasClass('sticked-stop'))
                    $('#search-map').removeClass('sticked-bottom').addClass('sticked-stop');
                else if (offset < footer_top && $('#search-map').hasClass('sticked-stop'))
                    $('#search-map').removeClass('sticked-stop').addClass('sticked-bottom');

                if (map_bottom < results_bottom && map_bottom <= offset && !$('#search-map').hasClass('sticked-bottom') && !$('#search-map').hasClass('sticked-stop'))
                    $('#search-map').addClass('sticked-bottom');
                else if (stop_offset > offset && $('#search-map').hasClass('sticked-bottom')) {
                    $('#search-map').removeClass('sticked-bottom');
                }
            });
        }
    }
    
    
    
    /*
     * iCheck functionality
     */
    if ($('input[type="checkbox"]').length) {
        $('input[type="checkbox"]').iCheck({
            labelHover: true,
            cursor: true
        });
    }
    
    
    
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
        $('.fancybox').fancybox();
    
    
    
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
});



function displayStarRating(obj, rating_defined) {
    if (rating_defined === null) {
        rating = parseInt(obj.attr('data-value'));
        ul_obj = obj.parent('ul');
    } else {
        rating = rating_defined;
        ul_obj = obj;
    }
            
    if (rating > 6)
        ul_obj.children('li').each(function(i, d) {
            if ($(d).attr('data-value') !== typeof undefined && $(d).attr('data-value') !== false)
                if (parseInt($(d).attr('data-value')) < rating)
                    $(d).children('i').removeClass('fa-star').addClass('fa-star-o');
                else
                    $(d).children('i').removeClass('fa-star-o').addClass('fa-star');
        });
    else
        ul_obj.children('li').children('i').removeClass('fa-star').addClass('fa-star-o');

    if (rating > 6 && rating < 10)
        rating_text = rating + '+';
    else if (rating == 10)
        rating_text = 'top';
    else
        rating_text = 'all';
    ul_obj.children('li.star-result').children('span').text(rating_text);
    
    //decoration
    ul_obj.children('li').removeClass('text-success');
    if (rating > 6)
        ul_obj.children('li').addClass('text-success');        
}



function updateStarRating(obj, rating_defined) {
    if (rating_defined === null) {
        rating = parseInt(obj.attr('data-value'));
        ul_obj = obj.parent('ul');
    } else {
        rating = rating_defined;
        ul_obj = obj;
    }
            
    displayStarRating(obj, rating_defined);

    if (rating > 6)
        ul_obj.children('li.star-result').children('input').val(rating);
    else
        ul_obj.children('li.star-result').children('input').val('');
}