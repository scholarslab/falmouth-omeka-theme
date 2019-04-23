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

<?php
    $bodyclass = 'page simple-page';
?>

<?php render('header'); ?>

<div id="pagecontent" class="grid_12 float left">
    <h1 class="item-title"><?php echo html_escape(simple_page('title')); ?></h1>
    <div class="simple-page-content"><?php echo eval('?>' . simple_page('text')); ?></div>
</div>

<?php render('footer');
