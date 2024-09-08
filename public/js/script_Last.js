$(window).on('resize', function(){
                var wid = $(window).width();
                if(wid<750)
                    {
                        $(".footerWrap").css({
                              'display':'none',
                            
                          });
                  
                    }
					else{
						$(".footerWrap").css({
                              'display':'block',
                            
                          });
					}
     });
    