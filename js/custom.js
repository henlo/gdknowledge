jQuery(document).ready(function() {

    // Open links in new tab
    jQuery('ul#primary-nav li a, .opennewtab').click( function(e) {
      e.preventDefault();
      window.open(jQuery(this).attr('href'));
    });

    jQuery('input#rh-search').focus(function () {
        if( jQuery(this).val() == 'Search the site' ) {
            jQuery(this).val('');
        }
    });
    jQuery('input#rh-search').blur(function () {
        if( jQuery(this).val() == '' ) {
            jQuery(this).val('Search the site');
        }
    });
    jQuery('input#rh-search-submit').click( function(e) {
        if( jQuery('input#rh-search').val() == 'Search the site' ) {
            e.preventDefault();
            jQuery('input#rh-search').focus();
        }
    });

    jQuery('button#submitform').click( function(e) {
        hlValidate(jQuery(this).parents('form'),e);
    });

    // Share on twitter and linked in
    var organisation = 'Goodman Derrick';
    var wlprot = window.location.protocol;
    var wlhost = window.location.host;
    var wlpath = window.location.pathname;
    var wlpathnew = wlpath.replace( /\//g, "%2F");
    var pt = document.title.split('|');
    pt = pt[0];
    var pagetitle = pt.replace(/[^a-zA-Z 0-9 -]+/g,'').replace(/  /, ' ');
    var fullURL = wlprot + "//www." +  wlhost + wlpath;

    var pagetitleLI = organisation + ' article %3A ' + pagetitle.replace(/ /g, "+");

    var fblink = "http://www.facebook.com/share.php?u=http%3A%2F%2Fwww."+wlhost+wlpathnew;
    var twlink = "http://twitter.com/share?url=http%3A%2F%2Fwww."+wlhost+wlpathnew+"&text="+pagetitle;
    var lilink = "http://www.linkedin.com/shareArticle?mini=true&url=http%3A%2F%2F"+wlhost+wlpathnew+"&title="+pagetitleLI+"&ro=false&summary=&source="

    jQuery('li#share-facebook a').attr('href',fblink);
    jQuery('li#share-twitter a').attr('href',twlink);
    jQuery('li#share-linkedin a').attr('href',lilink);

});

function hlValidate(thisForm,e) {

    e.preventDefault();    

    var isValid = 1;
    var thisFormID = '#' + jQuery(thisForm).attr('id');

    jQuery('p.errorinfo').remove();
    jQuery('input,label').removeClass('warning');

    jQuery(thisFormID + ' input.validate').each( function(index) {

        if( jQuery(this).hasClass('email') && jQuery(this).val().indexOf('@') < 1 ) {
            isValid = 0;
            jQuery(this).addClass('warning');
            jQuery('label[for="'+ jQuery(this).attr('id') +'"]').parent().append('<p class="errorinfo">Email address is invalid</p>');
            jQuery('label[for="'+ jQuery(this).attr('id') +'"]').addClass('warning');
        } else if( jQuery(this).val().length < 1 ) {
            isValid = 0;
            jQuery(this).addClass('warning');
            jQuery('label[for="'+ jQuery(this).attr('id') +'"]').addClass('warning');
        }

    });

    if( isValid == 1 ) {
        jQuery(thisForm).trigger("submit");
    } else {        
        jQuery('p.error,p.errorinfo').fadeOut('300');
        setTimeout( function(e) { 
            jQuery('p.error,p.errorinfo').fadeIn();
        },300);
    }    

}