//placeholder
$(function(){

    'use strict';
     
    //Dashboard 
    $('.toggle-info').click(function(){
          $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(200);
          if($(this).hasClass('selected')){
              $(this).html('<i class="fa fa-minus fa-lg"></i>');
          }else{
            $(this).html('<i class="fa fa-plus fa-lg"></i>');
          }
    });


    //trigger the selectboxit
   $("select").selectBoxIt({
        autoWidth:false
    });

    // confirmation Message on button
    $('.confirm').click(function(){
        return confirm('Are your sure ?');
    });
    

    //category view option 
    $(' .cat h3').click(function() {
        $(this).next('.full-view').fadeToggle(200);
    });

    $('.option span').click(function(){
       $(this).addClass('active').siblings('span').remove('active');
       if($(this).data('view') === 'full'){

           $('.cat .full-view').fadeIn(200);
       }else{
           
            $('.cat .full-view').fadeOut(200);
       }
    });

    //show Delete Button On child cats
    $('.child-link').hover(function(){
           this.find('show-delete').fadeIn();
    },function(){
        this.find('show-delete').fadeOut(400);
    });

    
});