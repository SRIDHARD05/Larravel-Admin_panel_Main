import './dashboard';

$(document).ready(function () {
    var path = window.location.pathname;

    $('.nav-link').each(function () {
        var linkPath = $(this).attr('href');
        if (linkPath === path) {
            $(this)
                .addClass('active bg-gradient-dark text-white')
                .removeClass('text-dark');
        } else {
            $(this)
                .removeClass('active bg-gradient-dark text-white')
                .addClass('text-dark');
        }
    });
});
