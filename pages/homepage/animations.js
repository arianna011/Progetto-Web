var t_slide = 800;
var t_fade = 2000;

$(document).ready( function()
        {
            $(".pres-slide").slideDown(t_slide);
            $(".pres-fade").fadeIn(t_fade);
            
            $(".carousel-control-prev").click( function() {
                  
                $(".pres-slide").hide();
                $(".pres-fade").hide();

            });

            $(".carousel-control-next").click( function() {
                  
                $(".pres-slide").hide();
                $(".pres-fade").hide();

            });

            $("#presentation").on('slid.bs.carousel', function () 
            {
                $(".pres-slide").slideDown(t_slide);
                $(".pres-fade").fadeIn(t_fade);
            });
            
        }
);



