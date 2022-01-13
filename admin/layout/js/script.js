//placeholder
$(function(){

    'use strict';
     
    //trigger the selectboxit
    $("select").selectBoxIt();

    // Hide Placeholder On Form Focus
    $('[placeholder]').focus(function(){
        
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });

    //Add Asterisk on required field
    $('input').each(function(){
        if($(this).attr('required') === 'required'){
            $(this).after('<span class="asterisk">*</span>');
        }
    });

    // convert  password field to text field on hover
    var passfield =$('password');
    $('.show-pss').hover(function(){
        passfield.attr('type','text');

    },function(){
        passfield.attr('type','password');
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
       if($(this).data('view')=== 'full'){
           $('.cat .full-view').fadeIn(200);
       }else{
        $('.cat .full-view').fadeOut(200);
       }
    });


    
});