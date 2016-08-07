$(function() {
    // Stripes animation
    $('#decorations .hidden').removeClass('hidden');

    // Services tabs
    var
        $serviceTabs = $('.tabs a');

    $serviceTabs.on('click', function() {
        var
            $link = $(this),
            $tabLinks = $link.siblings('a'),
            $tabsContent = $('.tabs-content .tab-content'),

            linkHref = $link.attr('href'),

            $currentTab = $tabsContent.filter('[rel="' + linkHref + '"]');

        $tabsContent.removeClass('show');
        $currentTab.addClass('show');

        if ($('.bx-wrapper', $currentTab).length === 0) {
            $('.bxslider', $currentTab).bxSlider();
        }

        $tabLinks.removeClass('active');
        $link.addClass('active');

        // Prevent default action
        // return false;
    });

    // Open link by hash
    var
        currentHash = window.location.hash || '#design' || '#description';
    $serviceTabs.filter('[href="' + currentHash + '"]').trigger('click');

    $('.peopleSlider').bxSlider();
    $('.objectSlider').bxSlider();
    // $('.objectGallery').bxSlider({
    //     pagerCustom: '#objectPager'
    // });
});
