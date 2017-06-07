/*
 * Search category select
 */
function activateCatDD() {
    if ($('.search-type-container').length) {
        //Init selected lists
        if ($('.topcategories li.selected').first().length) {
            var id = $('.topcategories li.selected').first().children('a').first().data('id');
            $('#subcats-'+id+' li.selected').first().addClass('preopen');

            activateSelectedCategory($('.topcategories li.selected').first().children('a').first());

            activateSelectedCategory($('.subcategories li.preopen').first().children('a').first());
            $('#subcats-'+id+' li.preopen').removeClass('preopen');
        }


        //Add new type to list
        $('.search-type-container .tab-pane a').on('click', function() {            
            var id = $(this).data('id');

            //Work with related subcategories
            if ($('#subcats-'+id).length) {
                //if has children


                if ($(this).parent('li').hasClass('selected')) {
                    $(this).parent('li').removeClass('selected');     

                    //hide next column lists
                    if ($(this).parent('li').parent('ul').parent('div').next('div').length) {
                        $(this).parent('li').parent('ul').parent('div').next('div').children('ul').hide();

                        if ($(this).parent('li').parent('ul').parent('div').next('div').next('div').length)
                            $(this).parent('li').parent('ul').parent('div').next('div').next('div').children('ul').hide();
                    }         
                } else {
                    activateSelectedCategory($(this));   
                }


                if (!$(this).parent('li').hasClass('selected')) 
                    updateTypesList($(this));
            } else {
                //if has no children

                updateTypesList($(this));
            }

            return false;
        });


        //Remove from types list
        $('#selected-types').on('click', 'a', function() {         
            var id = $(this).parent('li').data('id');       
            $('.search-type-container a[data-id='+id+']').parent('li').removeClass('active');

            $(this).parent('li').remove();

            updateTypesInput();

            return false;
        });


        //Activate dropdown
        $('.catdd-selector').on('touchstart mousedown', function(e) {
            e.preventDefault ();
            this.blur();
            offset = $(this).offset().top + 25;

            $('.search-type-container').css({top: offset}).show().removeClass('fadeOut').addClass('fadeIn');
            $('.categories-dropdown-litter').show();

            scroll_top_offset = $('.search-type-container').offset().top,
            scroll_top_duration = 700;

            $('body,html').animate({
                scrollTop: scroll_top_offset
                }, scroll_top_duration
            );

            return false;
        });


        //Hide dropdown
        $('.categories-dropdown-litter').click(function(e) {  
            e.preventDefault ();          
            $('.categories-dropdown-litter').hide();

            $('.search-type-container').removeClass('fadeIn').addClass('fadeOut');
            setTimeout("$('.search-type-container').hide();", 1500);
        });


        //Hide dropdown
        $('a.btn-accept-types').click(function(e) {    
            e.preventDefault ();                  
            $('.categories-dropdown-litter').hide();

            $('.search-type-container').removeClass('fadeIn').addClass('fadeOut');
            setTimeout("$('.search-type-container').hide();", 1500);

            return false;
        });
    }
}



function activateSelectedCategory(obj_a) {
    var id = obj_a.data('id');
    
    //remove selection from siblings
    obj_a.parent('li').siblings('li').removeClass('selected');
    if (obj_a.parent('li').parent('ul').parent('div').next('div').length)
        obj_a.parent('li').parent('ul').parent('div').next('div').children('ul').children('li.selected').removeClass('selected');
    obj_a.parent('li').addClass('selected');    

    //hide next column lists
    if (obj_a.parent('li').parent('ul').parent('div').next('div').length) {
        obj_a.parent('li').parent('ul').parent('div').next('div').children('ul').hide();

        if (obj_a.parent('li').parent('ul').parent('div').next('div').next('div').length)
            obj_a.parent('li').parent('ul').parent('div').next('div').next('div').children('ul').hide();
    }                

    //show related subcategory
    $('#subcats-'+id).show();
}



function updateTypesList(obj_a) {
    var id = obj_a.data('id');
    
    if ($('.catdd-selector').data('single') == '1') {
        $('.search-type-container .tab-pane li').removeClass('active');
    }
    obj_a.parent('li').toggleClass('active');

    if ($('.catdd-selector').data('single') == '0') {
        if (obj_a.parent('li').hasClass('active'))
            $('#selected-types').append('<li data-id="'+id+'"><a href="#">'+obj_a.text()+' <i class="fa fa-times"></i></a></li>');
        else
            $('#selected-types li[data-id='+id+']').remove(); 
    } else {        
        if (obj_a.parent('li').hasClass('active')) {
            $('#selected-types li').each(function(i, d) {
                if ($(d).data('id') != undefined)
                    $(d).remove();
            });
            
            $('#selected-types').append('<li data-id="'+id+'"><a href="#">'+obj_a.text()+' <i class="fa fa-times"></i></a></li>');
        } else
            $('#selected-types li[data-id='+id+']').remove(); 
    }
    
    updateTypesInput();
}



function updateTypesInput() {        
    if ($('.catdd-selector').data('single') == '0') {
        var val = [];
        var names = [];

        $('#selected-types li').each(function(i, d) {
            if ($(d).children('a').length) {
                val.push($(d).data('id'));
                names.push($(d).text());
            }
        });        
        
        $('#search-type').val(val.join(','));
        $('.catdd-selector').val(names.join(', '));
    } else {
        var val = $('#selected-types li').last().data('id');
        var names = $('#selected-types li').last().text();
        
        $('#search-type').val(val);
        $('.catdd-selector').val(names);
    }
}