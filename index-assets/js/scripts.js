$(document).ready(function() {

    // Show links.
    $('ul.list li div.project').click(function() {
        $(this).toggleClass('links-visible');
        $(this).parent().find('.project-links:first').stop().slideToggle('slow', 'easeOutBounce');
    });
    $('ul.list li div.project-links').click(function() {
        $(this).parent().find('div.project:first').toggleClass('links-visible');
        $(this).stop().slideToggle('slow', 'easeOutBounce');
    });

    //  Live filter.
    $('#filter').keyup(function(){

        // Retrieve the input field text.
        var filter = $(this).val();

        // Loop through the comment list.
        $('ul.list li .project').each(function(){
            // If the list item does not contain the text phrase fade it out.
            if ($(this).text().search(new RegExp(filter, 'i')) < 0) {
                $(this).parents('li').fadeOut('fast');

            // Show the list item if the phrase matches.
            } else {
                $(this).closest('.list-container').fadeIn('fast');
                $(this).parents('li').fadeIn('fast');
            }
        });
    });

    // Goto link on enter
    $('input.search').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            // Check for project link first
            if ($("div.projects ul li:visible").length == 1) {
                var trunk_href = $("div.projects ul li:visible a.trunk-link").attr('href');
                window.location.href = trunk_href;
            }
            // Check for tools link second
            else if ($("div.tools ul li:visible").length == 1) {
                var trunk_href = $("div.tools ul li:visible a").attr('href');
                window.location.href = trunk_href;
            }
            // Check for hotlink last
            else if ($("div.hotlinks ul li:visible").length == 1) {
                var trunk_href = $("div.hotlinks ul li:visible a").attr('href');
                window.location.href = trunk_href;
            }
        }
    });

    // Check if container should be hidden.
    function hideEmptyLists() {
        $('.list-container').each(function() {
            if (($(this).find('ul.list').children(':visible').length == 0) && ($(this).is(':visible'))) {
                $(this).fadeOut('fast');
            }
        });
    }
    setInterval(hideEmptyLists, 10);

    // Spyglass.
    $('input#filter').focus(function() {
        $('span.spyglass').addClass('searching');
    });
    $('input#filter').focusout(function() {
        $('span.spyglass').removeClass('searching');
    });


    // Init disco.
    if ($('input#switch').is(":checked")) {
        $('input.search').addClass('disco');
        $('body').addClass('disco');
        $('#clock').addClass('disco');
    }

    // Detect disco switch change.
    $('input#switch').change(function() {
        if($(this).is(":checked")) {
            document.cookie="disco=true";
            $('input.search').addClass('disco');
            $('#clock').addClass('disco');
            $('body').addClass('disco');
        } else {
            document.cookie="disco=false";
            $('input.search').removeClass('disco');
            $('#clock').removeClass('disco');
            $('body').removeClass('disco');
        }
    });

    // Hamburger nav.
    var menu_button = $(document).find('.cmn-toggle-switch');
    menu_button.click(function() {
        $(this).toggleClass('active');
        $('ul.admin-links').toggleClass('open');
    });

});
