var etat_side_bar=0;
var size_=0;
$(document).ready(function()
{    
    $('.close_side_bar').click(function(){
         $('.my_visible').click();
     });
    
    $('.back_icon').click(function(){
         history.back();
     });
 
     $('.my_visible').click(function(){
         
         show_or_hide(); 
     });
    $('.father_side_bar').click(function(){
         $('.my_visible').click();
     });
    $('#filter_icon').click(function(){
         if(etat_side_bar==1)
             {
                show_or_hide();
             }
        if(size_==0)
             {
                $('.top_header').css({
                     'max-height': '110px',
                    'height': '110px',
                 });
                 $('.body_app').css({
                     'padding-top': '150px',
                 });
                 size_=1;
             }
        else
            {
                $('.top_header').css({
                     'max-height': '75px',
                    'height': '75px',
                 });
                $('.body_app').css({
                     'padding-top': '100px',
                 });
                size_=0;
            }
         
     });
    
     $('#basic-addon3').click(function(){
     $('#job_submit').click();
  });
    
    
    
});

function show_or_hide()
{
    if(etat_side_bar==0)
             {
                 $('.father_side_bar').css({
                     'display': 'block',
                 }); 
                 $('.body_app').css({
                     'overflow': 'hidden',
                 });
                 $('.side_bar').removeClass('side_bar_etat1');
                 $('.side_bar').addClass('side_bar_etat');
                 etat_side_bar=1;
             }
         else
             {
                 $('.father_side_bar').css({
                     'display': 'none',
                 });
                 $('.body_app').css({
                     'overflow': 'auto',
                 });
                 
                 $('.side_bar').addClass('side_bar_etat1');
                 $('.side_bar').removeClass('side_bar_etat');
                 etat_side_bar=0;
             }
}