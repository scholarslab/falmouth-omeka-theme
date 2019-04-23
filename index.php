<?php
/**
 * "Falmouth" Theme main page
 *
 * Main landing page for the theme
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
 * @version   $Id: index.php 6708 2011-06-17 15:24:31Z wsg4w $
 * @link      http://www.scholarslab.org
 *
 * PHP version 5
 *
 */
?>
<?php 
common('_header', array('bodyclass' => 'mapshow'));
//render('header');
?>

<style type="text/css">
#wrapper { overflow: hidden; }
</style>

<div id="main_banner" class="grid_9">
    <?php  echo htmlspecialchars_decode(settings('description')); ?>
</div>

<div id="main_map" class="largemap grid_9">
</div>

<?php startFooterScript(); ?>
<script>
var map = main_map('main_map', {
    url: '<?php echo img('marker.png') ?>',
    size: 30
});
</script>
<?php endFooterScript(); ?>

<div class="grid_3 global_nav">
    <ul class="site-nav">
        <li class="site-nav-1">
            <div>
            
            <h3>
              <a href="<?php echo uri('solr-search/results/?q=*%3A*'); ?>">
                Explore Falmouth
              </a>
            </h3>


            <span>Explore Falmouth's Architecture &amp; History</span>
            </div>
        </li>
        <li class="site-nav-2">
            <div>
                <h3><?php echo exhibit_builder_link_to_exhibit('falmouth', 'History'); ?></h3>
                <span>Essays on the history of the city.</span>
            </div>
        </li>
        <li class="site-nav-3">
            <div>
            <h3><?php echo link_to_page('Help', 'help');?></h3>
            <span>Help using the site.</span>
            </div>
        </li>
    </ul>
</div>

<?php 
  render('footer');
