(function($) {
    var $nav = $('#main-nav');
    var $toggle = $('.toggle');
    var data = {};
    var defaultData = {
        maxWidth: false,
        customToggle: $toggle,
        levelTitles: true,
        pushContent: '#body'
    };

    // calling like this only for demo purposes

    const initNav = function(conf) {
        var $old = $('.hc-offcanvas-nav');

        setTimeout(function() {
            if ($old.length) {
                // clear previous instance
                $old.remove();
            }
        }, $toggle.hasClass('toggle-open') ? 320 : 0);

        if ($toggle.hasClass('toggle-open')) {
            $toggle.click();
        }

        // remove old toggle click event
        $toggle.off('click');

        // remember data
        $.extend(data, conf)

        // call the plugin
        $nav.clone().hcOffcanvasNav($.extend({}, defaultData, data));
    }

    // run first demo
    initNav({});

    $('.actions').find('a').on('click', function(e) {
        e.preventDefault();

        var $this = $(this).addClass('active');
        var $siblings = $this.parent().siblings().children('a').removeClass('active');

        initNav(eval('(' + $this.data('demo') + ')'));
    });

    $('.actions').find('input').on('change', function() {
        var $this = $(this);
        var data = eval('(' + $this.data('demo') + ')');

        if ($this.is(':checked')) {
            initNav(data);
        } else {
            var removeData = {};
            $.each(data, function(index, value) {
                removeData[index] = false;
            });
            initNav(removeData);
        }
    });
})(jQuery);



/* window height */
$(document).ready(function() {
    var wHeight = $(window).height();
    $('.vheight-100').css('height', wHeight );
});



/* image select */
$('input[type="file"]').each(function() {
    // Refs
    var $file = $(this),
        $label = $file.next('label'),
        $labelText = $label.find('span'),
        labelDefault = $labelText.text();

    // When a new file is selected
    $file.on('change', function(event) {
        var fileName = $file.val().split('\\').pop(),
            tmppath = URL.createObjectURL(event.target.files[0]);
        //Check successfully selection
        if (fileName) {
            $label
                .addClass('file-ok')
                // .css('background-image', 'url(' + tmppath + ')');
            $labelText.text(fileName);
        } else {
            $label.removeClass('file-ok');
            $labelText.text(labelDefault);
        }
    });

    // End loop of file input elements  
});




$(document).ready(function() {
    var opac = 1;
    $(".spnLeft").css({ 'opacity': opac });
    $(".spnRight").css({ 'opacity': opac });
    // Define cards
    var cards = [
        new Tindercardsjs.card(0)
    ];

    // Render cards
    Tindercardsjs.render(cards, $('#main'), function(event) {
        console.log('Swiped ' + event.direction + ', cardid is ' + event.cardid + ' and target is:');
        console.log(event.card);
        //console.log( var className = event.card[0]);

        /*if(event.direction === "left"){
            $(".sampleLeftDiv").show();
            $(".sampleRightDiv").hide();
        } else if(event.direction === "right"){
            $(".sampleRightDiv").show();
             $(".sampleLeftDiv").hide();
        }*/

        var className = jQuery(event.card[0]).attr('class').split(' ')[0];
        console.log(jQuery(event.card[0]).attr('class').split(' ')[0]);
        //$('.'+className).addClass("yes");
    });
});




$(document).ready(function() {
    $(function() {
        var count = 10
        var bottom = 0
        var transforms = 1;
        for (var i = count; i > 0; i--) {
            if (i <= 2) {
                $('.tiles-li-' + i).css("display", "none")
            } else {
                $('.tiles-li-' + i).css("display", "block")
            }

        }
    });
});

$(document).ready(function() {
    $(function() {
        var count = 5
        var zIndex = 0
        var transforms = 0.85;
        for (var i = 1; i <= count; i++) {
            zIndex++;
            transforms = transforms + 0.05;
            $('.tiles-li-' + i).css({
                'z-index': zIndex,
            });

        }
    });
});



/*==================== calendar ====================*/
// $(document).ready(function() {
//     $('#external-events .fc-event').each(function() {

//         // store data so the calendar knows to render an event upon drop
//         $(this).data('event', {
//             title: $.trim($(this).text()), // use the element's text as the event title
//             stick: true // maintain when user navigates (see docs on the renderEvent method)
//         });

//     });
//     $('#calendar').fullCalendar({
//         header: {
//             left: '',
//             center: 'prev title next',
//             right: 'month,agendaWeek,agendaDay'
//         },
//         aspectRatio: 1.15,
//         defaultDate: '2019-09-12',
//         fixedWeekCount: false,
//         navLinks: true, // can click day/week names to navigate views
//         editable: true,
//         eventLimit: true, // allow "more" link when too many events
//         droppable: true,
//         events: [{
//                 title: 'Looking for Web Designer',
//                 start: '2019-09-01'
//             },
//             {
//                 title: 'Looking for Web Designer',
//                 start: '2019-09-07'
//             },
//             {
//                 title: 'Looking for Web Designer',
//                 start: '2019-09-09'
//             },
//             {
//                 title: 'Looking for Web Designer',
//                 start: '2019-09-16'
//             },
//             {
//                 title: 'Looking for Web Designer',
//                 start: '2019-09-11'
//             },
//             {
//                 title: 'Looking for Web Designer',
//                 start: '2019-09-12'
//             },
//             {
//                 title: 'Looking for Web Designer',
//                 start: '2019-09-12'
//             },
//             {
//                 title: 'Looking for Web Designer',
//                 start: '2019-09-12'
//             },
//             {
//                 title: 'Looking for Web Designer',
//                 start: '2019-09-12'
//             },
//             {
//                 title: 'Looking for Web Designer',
//                 start: '2019-09-12'
//             },
//             {
//                 title: 'Looking for Web Designer',
//                 start: '2019-09-13'
//             }
//         ]
//     });

// });

 function openNav() {
  document.getElementById("mySidenav").style.width = "375px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

function openNavmob() {
  document.getElementById("mySidenavmob").style.width = "300px";
}

function closeNavmob() {
  document.getElementById("mySidenavmob").style.width = "0";
}




