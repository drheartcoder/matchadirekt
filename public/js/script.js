var etat=1
$(document).ready(function()
{    
     if($(window).width()<=1000)
            {
                $('.tools_icon').removeClass('col-md-1'); 
                 $('.tools_icon_2').removeClass('col-md-2');
                 $('#back_arrow').css({
                              'margin-left':'-5px!important',
                            'margin-top':'-6px!important'
                          });
                
            }
           
        else
            {
                $('.dashboard_div').css({
                    'display':'none',
                          });
                 $('.tools_icon').addClass('col-md-1');
                $('.tools_icon_2').addClass('col-md-2');
              
            }
           
    
    var wid=$(window).width();
   
    $(window).on('resize',function(){
        if($(window).width()<=1000)
            {
                $('.tools_icon').removeClass('col-md-1'); 
                 $('.tools_icon_2').removeClass('col-md-2');
                 $('#back_arrow').css({
                              'margin-left':'-5px!important',
                            'margin-top':'-6px!important'
                          });
                
            }
           
        else
            {
                $('.dashboard_div').css({
                    'display':'none',
                          });
                 $('.tools_icon').addClass('col-md-1');
                $('.tools_icon_2').addClass('col-md-2');
                
            }
           
     
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
                              'top':'110px',
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
                 $('.dashboard_div').show('slow');
         $('#back_arrow').css({
                              'display':'none',
                          });
          
        
  });
    $('#close_menu').click(function(){
                  $('.dashboard_div').hide('slow');
         $('#back_arrow').css({
             'display':'block',
                          });
         
  });
    
    $('.dashboard_icon').click(function(){
                 $('.dashboard_icon').css({
                    'text-decoration':'none',
                     'color':'white',
                    });
        });
        
        $('.frist_dashboard_icon').click(function(){
                 $('.frist_dashboard_icon').css({
                    'text-decoration':'none',
                     'color':'#444444',
                    });
  });

});

   


