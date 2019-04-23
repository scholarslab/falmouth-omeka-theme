<?php
/**
 * "Falmouth" Theme item browse partial
 *
 * Partial contains the browse view for items.
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
 * @version   $Id$
 * @link      http://www.scholarslab.org
 *
 * PHP version 5
 *
 */
?>
<?php //head(array('title' => 'Explore')); ?>
<?php //render('header'); 
  //common('_header', array('bodyclass' => 'mapshow'));
?>
<style>
.clearfix {
  font-family: courier, sans-serf;
}
</style>
<?php 

  $curl_hash = array();


function str_img_src($html) {
        if (stripos($html, '<img') !== false) {
            $imgsrc_regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
            preg_match($imgsrc_regex, $html, $matches);
            unset($imgsrc_regex);
            unset($html);
            if (is_array($matches) && !empty($matches)) {
                return $matches[2];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
  ?>  
<div class="clearfix">
<?php while(loop_items()): ?>

  <?php 
    $localDate = item('VRA Core', 'Date'); 
    $localDate = str_replace(' ', ' - ', $localDate); 
    $image = str_img_src(item_square_thumbnail()); 
    array_push($curl_hash, $image); 
?>
<?php echo item('id'); ?>,
  <?php echo ucwords(item('Dublin Core', 'Title')); ?>, 
  <?php echo $localDate; ?>,
  <?php echo item('Dublin Core', 'Identifier'); ?>,
  <?php echo ucwords(item_tags_as_string(', ', 'alpha', false)); ?>,
  <?php echo item('permalink'); ?>,
  <?php echo $image ?>

    <br/>
<?php endwhile; ?>

<p>-----------------------------------------</p>

<?php 
  for($i = 0; $i < sizeof($curl_hash); $i++) {
    echo "curl -O " . $curl_hash[$i] . "\n";
  }
?>

<?php //print_r($curl_hash); ?>
</div>


