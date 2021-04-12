$(function (){
'use strict';


//toggle latests
$('.toggle-info').click(function(){

 /* $('.panel-body').fadeToggle(200); */

 $(this).toggleClass('Selected').parent().next('.panel-body').fadeToggle(200);

            if($(this).hasClass('Selected')){

              $(this).html('<i class="fa fa-plus fa-lg"></i>');

            }else{

              $(this).html('<i class="fa fa-minus fa-lg"></i>');
              
            }

});
//hide Placeholder on focus
$('[placeholder]').focus(function(){
    $(this).attr('data-text', $(this).attr('placeholder'));
    $(this).attr('placeholder', '');
}).blur(function(){
$(this).attr('placeholder',$(this).attr('data-text'));
});

$('.Confirm').click(function(){
return confirm('Are you sure ?');
});
//show and hide  category

$('.cat h4').click(function(){

$(this).next('.full-view').fadeToggle(200);

});

$('.options span').click(function(){

 $(this).addClass('order-active').siblings('span').removeClass('order-active');   

if ($(this).data('view') === 'full'){

  $('.cat .full-view').fadeIn(200);

}else{

  $('.cat .full-view').fadeOut(200);


}

});

});