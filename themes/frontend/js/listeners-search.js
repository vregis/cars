$(document).ready(function() {
        
    
      /*  $($this).click(function() {
            //text = $(this).html();
           // $(#home-search-input).val(text);
            alert(1);
            
            return false;
        });*/
    /*
     * Options Extended Link
     */
    if ($('.options-extended-link a').length) {
        $('.options-extended-link a').click(function() {
            if ($('.options-extended').hasClass('open')) {
                $('.options-extended').removeClass('open');
                $('.options-extended-link').removeClass('open');
                
                $('.options-extended').animate({height: '50px'}, 300);
                $('.options-extended-link').animate({backgroundPositionY: '0', height: '80px', marginBottom: '0px'}, 300);
            } else {
                $('.options-extended').addClass('open');
                $('.options-extended-link').addClass('open');
                
                $('.options-extended').animate({height: $('.options-extended')[0].scrollHeight}, 300);
                $('.options-extended-link').animate({backgroundPositionY: $('.options-extended')[0].scrollHeight, height: '30px', marginBottom: '50px'}, 300);
            }
            
            return false;
        });
    }
    
    
    
    /*
     * Home search input
     */
    if ($('#home-search-input').length) {
        var home_animation_time = 300;
        
        $('#home-search-input').on('keyup', function() {
            text = $(this).val();
            if (text.length > 2) {
                //$('#home-search-results').slideUp(home_animation_time);

                $.ajax({
                    type: "POST",
                    dataType: "html",
                    cache: false,
                    context: this,
                    url: 'http://'+location.hostname+'/site/gMapsAutocomplete',
                    data: {
                        text: text
                    },
                    success: function(data){
                        $('#home-search-results li').each(function(i, d) {
                            if (!$(d).hasClass('first'))
                                $(d).remove();
                        });

                        $('#home-search-results').append(data);

                        if (!$('#home-search-results').hasClass('opened')) 
                            $('#home-search-results').slideDown(home_animation_time).addClass('opened');
                    }
                });
            } else {
                $('#home-search-results').slideUp(home_animation_time).removeClass('opened');
            }
        });
        
        $('#home-search-input').on('blur', function() {
            $('#home-search-results').slideUp(home_animation_time);
        });
    }
    
    
    
    /*
     * Search location input
     */
    if ($('#search-location').length) {
        var home_animation_time = 300;
        
        $('#search-location').on('keyup', function() {
            text = $(this).val();
            if (text.length > 2) {
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    cache: false,
                    context: this,
                    url: 'http://'+location.hostname+'/site/gMapsAutocomplete',
                    data: {
                        text: text
                    },
                    success: function(data){
                        $('#home-search-results li').each(function(i, d) {
                            if (!$(d).hasClass('first'))
                                $(d).remove();
                        });

                        $('#home-search-results').append(data);

                        if (!$('#home-search-results').hasClass('opened')) 
                            $('#home-search-results').slideDown(home_animation_time).addClass('opened');
                    }
                });
            } else {
                $('#home-search-results').slideUp(home_animation_time).removeClass('opened');
            }
        });
        
        $('#location-results-cover').on('click', 'a', function() {
            text = $(this).text();
            $('#search-location').val(text);
            $('#home-search-results').slideUp(home_animation_time);
            
            return false;
        });

        
        
        $('#search-location').on('blur', function() {
            $('#home-search-results').slideUp(home_animation_time);
        });
    }
    

    
    /*
     * Search Pagination Scroll
     */
    if ($('#search-pagination').length) {
        $('#search-pagination-list').hide();
        
        $(window).on('scroll', function() {
            bottom_line = $(this).scrollTop() + $(window).height();
            pagination_bottom = $('#search-pagination').offset().top + $('#search-pagination').height();
            
            if (bottom_line > pagination_bottom && !$('#search-pagination').hasClass('loading')) {
                $('#search-pagination').addClass('loading');
                
                url = window.location.toString();
                var total = parseInt($('#search-pagination').attr('data-max-page'));
                var current_page = parseInt($('#search-pagination').attr('data-page'));
                var next_page = current_page+1;
                
                if (current_page < total) {
                    
                    if (url.search('page='+current_page) > 0)
                        url = url.replace('page='+current_page, 'page='+next_page);
                    else if (url.search(/s\?/i) > 0)
                        url = url + '&page='+next_page;
                    else
                        url = url + '?page='+next_page;

                    $('#search-pagination .ajax-loader').show();

                    $.ajax({
                        type: "POST",
                        dataType: "html",
                        cache: false,
                        context: this,
                        url: url,
                        data: {
                            ajax: 1
                        },
                        success: function(data) {
                            output = $.parseJSON(data);
                            $('#search-data').append(output.html);
                            
                            $('#search-pagination .ajax-loader').hide();
                            $('#search-pagination').removeClass('loading');
                            $('#search-pagination').attr('data-page', next_page);
                            
                            latlng = [];
                            output.map.forEach(function(el, i, arr) {
                                var coords = new google.maps.LatLng(el.coords[0], el.coords[1]);
                                latlng.push(coords);
                                
                                switch (el.range) {
                                    case 0: src = 'pin-success'; break
                                    case 1: src = 'pin-primary'; break
                                    case 2: src = 'pin-warning'; break
                                    case 3: src = 'pin-danger'; break
                                    default: src = 'pin-success'; break
                                }
                                
                                var image = {
                                    url: 'http://'+location.hostname+'/themes/frontend/img/'+src+'.png',
                                    size: new google.maps.Size(20, 32),
                                    anchor: new google.maps.Point(10, 32),
                                    origin: new google.maps.Point(0, 0)
                                };
                                
                                marker_name = 'Marker' + el.id;
                                infowindow_name = 'InfoWindow' + el.id;
                                
                                //New marker
                                if (typeof window[marker_name] === "undefined") {
                                    var marker = new google.maps.Marker({
                                        position: coords,
                                        icon: image,
                                        map: EGMap0
                                    });
                                
                                    var infowindow = new google.maps.InfoWindow({
                                        content: el.label
                                    });

                                    marker.addListener('click', function() {
                                        infowindow.open(EGMap0, marker);
                                    });
                                    
                                    window[marker_name] = marker;
                                    window[infowindow_name] = infowindow;
                                } else if (typeof window[infowindow_name] !== "undefined") {
                                //Existing marker    
                                    infowindow = window[infowindow_name];
                                    content = infowindow.getContent();
                                    content += el.label;
                                    infowindow.setContent(content);
                                    
                                    old_icon = window[marker_name].getIcon();
                                    if (old_icon.url.search('pin-success') > 0) old_range = 0; else
                                    if (old_icon.url.search('pin-primary') > 0) old_range = 1; else
                                    if (old_icon.url.search('pin-warning') > 0) old_range = 2; else
                                    if (old_icon.url.search('pin-danger') > 0) old_range = 3; else old_range = 0;
                        
                                    if (old_range > parseInt(el.range))
                                        window[marker_name].setIcon(image);
                                }
                            });
                            
                            var latlngbounds = EGMap0.getBounds();
                            for (i=0; i < latlng.length; i++) {
                                latlngbounds.extend(latlng[i]);
                            }
                            EGMap0.setCenter(latlngbounds.getCenter());
                            EGMap0.fitBounds(latlngbounds);
                        },
                        error: function (a, b, c) {
                            alert(a.responseText);
                        }
                    });
                }
            }
        });
    }
    
        
    
    
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
     * Search reset
     */
    if ($('#main-search input[type="reset"]').length) 
        $('#main-search input[type="reset"]').click(function() {
            loc = $('#search-location').val();
            
            $('#main-search input[type="text"], #main-search input[type="hidden"], #main-search select').val('');
            $('.star-rating').each(function(i, d) {
                rating = parseInt($(d).children('li.star-result').children('input').val());

                displayStarRating($(d), rating);
            });
            
            $('#search-location').val(loc);
            $('#advanced-search').find('input[type="checkbox"]').iCheck('uncheck');
            
            $('#main-search').submit();
            
            return false;
        });
    
    
    
    /*
     * Search sort
     */
    if ($('#main-search .results-sort').length) 
        $('#main-search .results-sort').on('click', function() {
            if ($(this).data('type') == 'rating') val = 2;
            if ($(this).data('type') == 'distance') val = 4;
            if ($(this).data('type') == 'price') val = 8;
            
            if ($(this).data('value') == val) $(this).attr('data-value', '0'); else $(this).attr('data-value', val);
            
            total_val = 0;
            
            $('.results-sort').each(function(i, d) {
                total_val += parseInt($(d).attr('data-value'));
            });
                        
            $('#search-sort-value').val(total_val);            
            $('#main-search').submit();
            
            return false;
        });
    
    
    
    /*
     * Map Positioning
     */
    if ($('#search-map').length && $(window).width() > 750) {                
        $('#search-results-cover').css('min-height', $(window).height()-50);
        $('#search-map').height($(window).height());
        $('#search-map .map-container > div').height($(window).height());
        //bounds = EGMap0.getBounds();
        //google.maps.event.trigger(EGMap0, 'resize');
        //map_center = $('#search-map .map-container').attr('data-center');
        //EGMap0.setCenter(map_center);
        //EGMap0.setBounds(bounds);
        
        map_bottom = $('#search-map').offset().top + $(window).height();
        footer_top = $('#subscription-footer').offset().top;
        var stop_offset = $('#search-map').offset().top + $('#search-map').height();
        
        //if (map_bottom < footer_top) {
            $(window).on('scroll', function() {
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
        //}
    }
    
    
    
    /*
     * Show info window on mouse over
     */
    if ($('.offer-short-info').length) {
        $('#search-data').on('mouseover', '.offer-short-info', function(e) {
            e.preventDefault();
                    
            ids = $(this).data('address-id');
            if (typeof ids === "string") {
                ids_list = ids.split(',');
            } else {
                ids_list = Array();
                ids_list.push(ids);
            }
            ids_list.forEach(function(el, i, arr) {
                marker_name = 'Marker' + el;
                if (typeof window[marker_name] !== "undefined") {
                    //google.maps.event.trigger(window[marker_name], 'click');
                    window[marker_name].setAnimation(google.maps.Animation.BOUNCE);                    
                }
            });
        }).on('mouseleave', '.offer-short-info', function() {
            ids = $(this).data('address-id');
            if (typeof ids === "string") {
                ids_list = ids.split(',');
            } else {
                ids_list = Array();
                ids_list.push(ids);
            }
            ids_list.forEach(function(el, i, arr) {
                marker_name = 'Marker' + el;
                if (typeof window[marker_name] !== "undefined") {
                    //window[infowindow_name].close();
                    window[marker_name].setAnimation(null);                    
                }
            });
        });
    }  
    
    
    /*
     * Search category select
     */
    activateCatDD();
        
});



function displayStarRating(obj, rating_defined) {
    if (rating_defined === null) {
        rating = parseInt(obj.attr('data-value'));
        ul_obj = obj.parent('ul');
    } else {
        rating = rating_defined;
        ul_obj = obj;
    }
            
    if (rating > 1)
        ul_obj.children('li').each(function(i, d) {
            if ($(d).attr('data-value') !== typeof undefined && $(d).attr('data-value') !== false)
                if (parseInt($(d).attr('data-value')) < rating)
                    $(d).children('i').removeClass('fa-star').addClass('fa-star-o');
                else
                    $(d).children('i').removeClass('fa-star-o').addClass('fa-star');
        });
    else
        ul_obj.children('li').children('i').removeClass('fa-star').addClass('fa-star-o');

    if (rating > 1 && rating < 5)
        rating_text = rating + '+';
    else if (rating == 5)
        rating_text = 'top';
    else
        rating_text = 'all';
    ul_obj.children('li.star-result').children('span').text(rating_text);
    
    //decoration
    ul_obj.children('li').removeClass('text-success');
    if (rating > 1)
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

    if (rating > 1)
        ul_obj.children('li.star-result').children('input').val(rating);
    else
        ul_obj.children('li.star-result').children('input').val('');
}