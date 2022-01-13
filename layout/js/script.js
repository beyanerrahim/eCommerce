//placeholder
$(function(){

    'use strict';
     
    //switch between login and signup
    $('.login-page h2 span').click(function(){

       $(this).addClass('selected').siblings().removeClass('selected');
       
       $('.login-page form').hide();

       $('.'+$(this).data('class')).fadeIn();
    });

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
   
    // confirmation Message on button
    $('.confirm').click(function(){
        return confirm('Are your sure ?');
    });
    
    $('.live').keyup(function(){

       $($(this).data('class')).text($(this).val());
    });
    
    
});