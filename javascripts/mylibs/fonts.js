/**
 * Google Font API loader
 */
var WebFontConfig = {
    // add any fonts to load for the CSS here
    google: { families: ['Neuton' ] }
};

// TODO: rewrite this as jquery plugin
(function(){
   var wf = document.createElement('script');
   wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
       '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
   wf.type = 'text/javascript';
   wf.async = 'true';
   var s = document.getElementsByTagName('script')[0];
   s.parentNode.insertBefore(wf, s);

})();

