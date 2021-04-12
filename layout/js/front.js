$(function (){
'use strict';

//create new ad with ajax

$('#CreateNewAd').click(function(){

        $.ajax({
                url : "createNewAd.php",
                method : "POST" ,
                data : $("form#formCreateNewAd").serializeArray(),
                success : function(data){

                        if(data == "ok"){

                                $("#showErrs").html("<div class='alert alert-success' ><strong>The Item has been successfully added </strong> wait for it to be accepted by the administrator ! thank you</div>");
                                $('.vider').val("");
                        }else{

                                $("#showErrs").html(data);
                        }
                 
                        

                                           }
                });

});


//Live Show details of the item [Create new ad]
$(".live").keyup(function(){
$($(this).data('class')).text($(this).val());
});





//validation of password (Sign up form)
$('#pass2,#pass1').keyup(function(){

        if( $('#pass1').val() == "" && $('#pass2').val() == ""  ){
                
    $('#passStatus').html("<strong class='text-danger'>Passwords cant be empty !</strong>");
                                                                                  
        }else{

            if(   $('#pass1').val() === $('#pass2').val() ){

                    $('#passStatus').text("");
                    $('#passStatus').html("<b class='text-success'>Passwords correcte</b>");
                
            } else {
                
                    $('#passStatus').html("<strong class='text-primary'>Passwords are different !</strong>");

            }

      }



});



//login with ajax 

$("#btnlogin").click(function fun(){
        $.ajax({
        url : "loginSignup.php",
        method : "POST" ,
        data : $("form#login").serializeArray(),
        success : function(data){
         
                if(data == '<div class="alert alert-danger text-center">Username or password is <strong>incorrect !</strong></div>'){

                  $("#errmsg").html(data); 
                        
                }else{

                 top.location.href="index.php";

                }


                                }
        });
});


//signup with ajax 
$("input#usernameLogin").keyup(function(){

  $("#errmsg").html("");
       
});

$("input#signup").click(function fun(){
        $.ajax({
        url : "loginSignup.php",
        method : "POST" ,       
        data : $("form#signup").serializeArray(),
        success : function(data){
         
                if(data == 'Ok'){

$("#spansignup").removeClass('selected');
$("#spanlogin").addClass('selected');
$("form#signup").hide();
$("form#login").show();
$("#signup input").val("");
$("#passStatus").html("");
$("div#errsignup").html(""); 

$("div#successmsg").html("<div class=' text-center alert alert-success col-lg-6 col-md-12 col-sm-12 mt-5 '><strong>Succesfully !</strong> You have to login now</div>"); 


                }else{

 $("div#errsignup").html(data);                

                }


                                }
        });
});

//end signup ajax

//check the username is exist with ajax Search

$("#username").keyup(function fun(){

        $("div#errsignup").html("");

        $.ajax({
        url : "search.php",
        method : "POST" ,
        data : $("form#signup").serializeArray(),
        success : function(data){
                  $("#res").html(data);

                  if(data == ""){
                
                        $('input#hideinput').val("NotExist");

                  }else{

                        $('input#hideinput').val("Exist");


                  }

                  
                                }
        });
});



//switch between login and signup

$('.login-page h2 span').click(function(){

$(this).addClass('selected').siblings().removeClass('selected');

$('.login-page form').hide();

$('.'+$(this).data('class')).fadeIn(100);

});

//end switch between login and signup
//hide Placeholder on focus
$('[placeholder]').focus(function(){
    $(this).attr('data-text', $(this).attr('placeholder'));
    $(this).attr('placeholder', '');
}).blur(function(){
$(this).attr('placeholder',$(this).attr('data-text'));
});
//confirm alert
$('.Confirm').click(function(){
return confirm('Are you sure ?');
});



});