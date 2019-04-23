<?php
/**
 * "Falmouth" Theme custom pagination control
 *
 * This file overrides the default pagination control in
 * application/views/scripts/common/pagination_control.php
 *
 * @example <?php echo pagination_links(array('partial_file' => 'overrides/pagination_control.php'); ?>
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
 * @version   $Id: header.php 5808 2010-10-20 20:59:05Z wsg4w $
 * @link      http://www.scholarslab.org
 *
 * PHP version 5
 *
 */
?>
<?php if($this->pageCount > 1): ?>
<ul class="pagination_list">
    <?php if($this->first != $this->current): ?>
        <!-- first page link -->
        <li class="pagination_first">
            <a href="<?php echo html_escape($this->url(array('page' => $this->first), null, $_GET)); ?>">First</a>
        </li>
    <?php endif ?>

    <?php if (isset($this->previous)): ?>
        <!-- Previous page link -->
        <li class="pagination_previous">
            <a href="<?php echo html_escape($this->url(array('page' => $this->previous), null, $_GET)); ?>">Previous</a>
        </li>
    <?php endif; ?>

     <!-- Numbered page links -->
    <?php foreach ($this->pagesInRange as $page): ?>
        <?php if ($page != $this->current): ?>
            <li class="pagination_range">
                <a href="<?php echo html_escape($this->url(array('page' => $page), null, $_GET)); ?>"><?php echo $page; ?></a>
           </li>
        <?php else: ?>
            <li class="pagination_current"><?php echo $page; ?></li>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if (isset($this->next)): ?>
        <!-- Next page link -->
        <li class="pagination_next">
            <a href="<?php echo html_escape($this->url(array('page' => $this->next), null, $_GET)); ?>">Next</a>
        </li>
    <?php endif; ?>

    <?php if ($this->last != $this->current): ?>
        <!-- Last page link -->
        <li class="pagination_last">
            <a href="<?php echo html_escape($this->url(array('page' => $this->last), null, $_GET)); ?>">Last</a>
        </li>
    <?php endif; ?>
            
</ul>
<?php endif ?>
