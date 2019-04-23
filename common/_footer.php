<?php
/**
 * Footer content for Falmouth theme
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at http://www.apache.org/licenses/LICENSE-2.0 Unless required by
 * applicable law or agreed to in writing, software distributed under the
 * License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS
 * OF ANY KIND, either express or implied. See the License for the specific
 * language governing permissions and limitations under the License.
 *
 * @package   omeka
 * @author    "Scholars Lab"
 * @copyright 2010 The Board and Visitors of the University of Virginia
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 * @version   Release: 0.0.1-pre
 * @link      http://www.scholarslab.org
 *
 * PHP version 5
 *
 */
?>
    </div> <!-- end #main -->
    <footer id="footer" class="clearfix grid_12">
        <div class="grid_6 footer">
            <p><strong><em>The Falmouth Project</em></strong> is
            authored by <a href="http://www.virginia.edu/art/artarch/faculty/nelson.html">Louis P. Nelson</a>, Associate Professor and Chair, <a href="http://www.virginia.edu/art/artarch/">Department of
            Architectural History</a>, <a href="http://www.virginia.edu">University of Virginia</a>.</p>
        </div>
        <div class="grid_6 footer contact-info" style="float: right;">
<div class="footright">
    <a id="slab-logo" href="http://www.scholarslab.org">
       <img src="<?php echo img('slab_logo.png'); ?>" alt="Scholars' Lab logo" />
    </a>
</div>
<div class="footright">
    <a rel="license" href="http://creativecommons.org/licenses/by/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by/3.0/88x31.png" /></a>
</div>
<div id="cc-logo" class="footright">
    This work is CC licensed.<br />
    <a href="mailto:ln6n@virginia.edu?subject=Falmouth%20Project%20Website">Contact Us</a>
</div>
        </div>
    </footer><!-- end footer -->
    <p class="grid_12 footer clearfix">
        <a class="float right" href="#top">top</a>
    </p>
</div><!-- end #wrapper -->
</div><!-- end #page -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="js/libs/jquery-1.5.2-min.js"%3E%3C/script%3E'))</script>

<?php echo javascript_include_tag('mylibs/proj4js-combined'); ?>
<?php echo javascript_include_tag('mylibs/jquery.cookie'); ?>
<?php echo javascript_include_tag('mylibs/fonts, mylibs/footer'); ?>

<!--[if lt IE 7 ]>
<?php echo javascript_include_tag('libs/dd_belatedpng'); ?>
<script> DD_belatedPNG.fix('img, .png_bg');</script>
<![endif]-->

<?php
echoFooterScripts();
?>
<script>
var _gaq=_gaq||[];_gaq.push(['_setAccount','UA-23643512-1']);_gaq.push(['_trackPageview']);(function(){var ga=document.createElement('script');ga.type='text/javascript';ga.async=true;ga.src=('https:'==document.location.protocol?'https://ssl':'http://www')+'.google-analytics.com/ga.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(ga,s);})();
</script>

</body>
</html>
