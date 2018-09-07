$(function () 
        {
         var speed = 1, timer;
        $("#hoverscroll").hover(
            function () 
            {
            var div = $('body');
             (function startscrolling()
                {
                timer = setTimeout(function () 
                    {
                    var pos = div.scrollTop();
                    div.scrollTop(pos + speed);
                    startscrolling();
                     }, 100      );
                }
             )();
             },
            function () 
                {
                clearTimeout(timer);
                speed = 1;
                }
                                )
    .click(function()
                {
                if (speed < 6) speed++;
                }
          );

          }
);