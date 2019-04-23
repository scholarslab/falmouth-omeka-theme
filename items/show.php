<?php
/**
 * "Falmouth" Theme item show partial
 *
 * Partial contains the display view for items.
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
<?php //head(array('title' => item('Dublin Core', 'Title'))); ?>
<?php render('header'); ?>
<style type='text/css'>
.element-set h2 { display: none; }
</style>

<div id="filecontent" class="grid3 float left">
    <!-- display all files associated with an item -->
    <div id="itemfiles">
        
        <div class="element-files">
            <?php
                // set the options to show a png for PDF files rather than
                // the default title
                $media_options = array(
                    'showFilename' => false,
                    'linkToFile' => true,
                    'icons' => array(
                        'application/pdf' => img('pdf.png')
                        )
                    );
                
                echo display_files_for_item($media_options); ?>
        </div>
    </div>
</div><!-- end #filecontent -->
<div id="itemcontent" class="grid_9 float right">
    <h1 class="item-title"><?php echo item('Dublin Core', 'Title'); ?></h1>

    <?php echo show_item_metadata(array('show_empty_elements' => false, 'show_element_sets' => array('VRA Core'))); ?>

    <?php if (item_has_tags()): ?>
    <!-- display tags -->
    <div class="tags" class="element">
	<h3>Usage</h3>
	<div class="element-text"><?php echo item_tags_as_string(); ?></div>
    </div>
    <?php endif;?>

    <!-- print the citation -->
    <div id="citation">
        <h2>Citation</h2>
        <div id="citation-text">
            <?php echo item_citation(); ?>
        </div>
    </div>
</div> <!-- end #itemcontent -->

<?php render('footer');
