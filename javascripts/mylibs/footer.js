//TODO: document and put in header

$(function() {
    // apply tabs for jquery ui
    var tab_options = {
        cookie: { expires: 30 },
        create: function(ev, ui) {
            var tab = $('#browse_tabs').tabs('option', 'selected');
            if (tab !== undefined) {
                window.location.hash = 'uitab=' + tab;
            }
        },
        select: function(ev, ui) {
            window.location.hash = 'uitab=' + ui.index;
        }
    };
    var uitab = /uitab=(\d+)/g;
    var match = uitab.exec(window.location.hash);
    if (match !== null) {
        tab_options.selected = match[1];
    } else {
    }
    $("#browse_tabs").tabs(tab_options);

    // for site nav, li becomes the link
    $(".site-nav li").click(function(){
        var $this = $(this)
        var link = $this.children().children('h3').children('a').attr('href');
        window.location.href = link;
        return false;

    });
});

// li div h3 a
