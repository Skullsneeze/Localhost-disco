$(document).ready(function() {

    // Show links
    $('ul.list li').click(function() {
        $(this).find('.project-links:first').stop().slideToggle('slow', 'easeOutBounce');
    });

    //  Live filter
    $("#filter").keyup(function(){

        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val();

        // Loop through the comment list
        $("ul.list li .project").each(function(){

            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).parents('li').fadeOut('fast');

            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).closest('.list-container').fadeIn('fast');
                $(this).parents('li').fadeIn('fast');
            }

        });

    });

    // check if container should be hidden
    function hideEmptyLists() {
        $('.list-container').each(function() {
            if (($(this).find('ul.list').children(':visible').length == 0) && ($(this).is(':visible'))) {
                $(this).fadeOut('fast');
            }
        });
    }
    setInterval(hideEmptyLists, 10);

    // Spyglass
    $('input#filter').focus(function() {
        $('span.spyglass').addClass('searching');
    });
    $('input#filter').focusout(function() {
        $('span.spyglass').removeClass('searching');
    });


    // init disco
    if ($('input#switch').is(":checked")) {
        $('input.search').addClass('disco');
        $('body').addClass('disco');
        $('#clock').addClass('disco');
    }

    // detect disco switch change
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

});
