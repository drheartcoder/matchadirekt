var etat=1
$(document).ready(function()
{    
     if($(window).width()<=700)
           $('.tools_icon').removeClass('col-md-1'); 
        else
            $('.tools_icon').addClass('col-md-1');
    
    var wid=$(window).width();
   
    $(window).on('resize',function(){
        if($(window).width()<=700)
            {
                $('.tools_icon').removeClass('col-md-1'); 
                 $('#back_arrow').css({
                              'margin-left':'-5px!important',
                            'margin-top':'-6px!important'
                          });
            }
           
        else
            $('.tools_icon').addClass('col-md-1');
     
    });
            

   $(window).scroll(function()            
     {
         var sd = $(window).scrollTop();
     
       if(sd>=50){

                 $('#div_nav').addClass('fix_me');
                $('#back_arrow').css({
                              'top':'60px',
                            
                          });

       }else
           {
                $('#div_nav').removeClass('fix_me');
                $('#back_arrow').css({
                              'top':'109px',
                          });
           }
      });
  $('#basic-addon1').click(function(){
     $('#input_search').click();
  });
    
     $('#basic-addon2').click(function(){
     $('#resume_submit').click();
  });
    
     $('#basic-addon3').click(function(){
     $('#job_submit').click();
  });
    
     $('#back_arrow').click(function(){
                 $('.dashboard_div').slideDown('slow');
         $('#back_arrow').css({
                              'display':'none',
                          });
          $('#close_menu').css({
                              'display':'block',
                          });
        
  });
    $('#close_menu').click(function(){
                  $('.dashboard_div').slideUp('slow');
         $('#back_arrow').css({
             'display':'block',
                          });
          $('#close_menu').css({
                              'display':'none',
                          });
  });
    
});

