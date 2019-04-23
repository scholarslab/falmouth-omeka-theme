<?php
/**
 * "Falmouth" Theme SolrSearch results override
 *
 * Custom functions for the Falmouth Omeka theme
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

<?php render('header', array('title' => 'Explore Falmouth', 'bodyclass' => 'mapshow')); ?>
<style>
.item-entry {
  margin-left: 0;
  height: 480px;
  font-size: 14px;
  display: block;
}

.item-entry h3 {
  font-size: 16px;
  padding: 0.5em 0;
}
.item-entry .tags {
  padding: 1em 0;
}
</style>


<div class='grid_3 alpha'>&nbsp;</div>

<div id="browse_tabs" class="clearfix">
    <ul>
        <li><a href="#map_view">Map</a></li>
        <li><a href="#item_view">Buildings</a></li>
    </ul>

    <?php
        if ($results->response->numFound > 0) {
            $nameIndex = solr_search_get_element_names();
            $magGlass = img('magnifying_glass.gif');
        }
        $query = new SolrSearch_QueryManager();
    ?>

    <?php if ($results->response->numFound > 0): ?>
      <div class="alpha grid_3 solr_facets">
        <ul class="solr_facet_list">
          <?php foreach($results->facet_counts->facet_fields as $facet => $values): ?>
            <?php 
              $facet_class = falmouth_get_element_name($nameIndex, $facet); 
            ?>

            <li class="facet_<?php echo strtolower($facet_class); ?>">
              <h4><?php echo $facet_class ?></h4>
              <ul class="solr_facet_values">
                <?php foreach($values as $label => $count): ?>
                  <?php 
                     $qlabel = "\"$label\"";
                     $slabel = fix_date_range_label($label);
                     $slabel = truncate_label($slabel, 16);
                     $fp = trim($query->getFacetParameter($facet), '"');
                  ?>
                  
                <li>
                    <?php
                        if ($fp == $qlabel) {
                            $link = $query->makeLinkRemoveFacet($facet);
                            echo "<span class='fn'><b>$slabel</b></span>";
                            echo "<a class='facet-remove' href='$link'>X</a>";
                        } else {
                            $link = $query->makeLinkAddFacet($facet, $qlabel);
                            echo "<span class='fn'><a href='$link'>$slabel</a></span>";
                            echo "<span class='fc'>$count</span>";
                        }
                    ?>
                  </li>
                <?php endforeach; ?>
              </ul>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php
        $p = Zend_Registry::get('pagination');
        $page = $p['page'];
        $perPage = $p['per_page'];
        $total = $p['total_results'];
        $pageFrom = $perPage * ($page - 1) + 1;
        $pageTo = min($perPage * $page, $total);
      ?>
      <div class="search-results grid_9 omega">
        <h3 class='search-title clearfix'>
          Current Query
          <img src="<?php echo $magGlass; ?>" />
          <?php echo really_simple_search(); ?>
        </h3>
        <ul class='search-body clearfix'>
          <?php echo falmouth_remove_facets($query, $nameIndex); ?>
        </ul>
        <div class='search-total clearfix'>
          Displaying items
          <b><?php echo "$pageFrom &ndash; $pageTo"; ?></b>
          of
          <b><?php echo $total; ?></b>
          <a href="./" id="start-over">Start Over</a>
        </div>
    </div>

    <?php endif; ?>

    <div id="map_view" class="grid_2 clearfix omega">
        <div id="map_browser" class="grid_8_map"></div>
        <!-- <div class="grid_2"><h2>Tools</h2></div> -->
    </div>

    <div id="item_view" class="grid_9 clearfix omega">
      <?php if ($results->response->numFound > 0): ?>
        <div class="solr_results search_results">
          <h2>Results</h2>

          <?php foreach($results->response->docs as $doc): ?>

          <?php
            $tag = $doc->getField('tag');
            $description = $doc->getField('108_s');
            $image = $doc->getField('image');
            $image_id = $image['value'][0]; // get the id of the first image
            if($image_id) {
              $image_path = solr_search_image_path('square_thumbnail', $image_id);
            }
            $item_link = solr_search_result_link($doc);
            $item_uri = uri('/items/show/' . $doc->id);
          ?>
          <div class="grid_3 item-entry">
            <div class="item-img">
            <?php if(isset($image_path)): ?>
              <a href="<?php echo $item_uri; ?>"><img src="<?php echo $image_path?>" /></a>
            <?php endif; ?>
            </div>
            <h3><?php echo $item_link; ?></h3>
            <div class="item-description">
            <?php if(sizeof($description) > 0): ?>
              <?php echo limit_text($description['value'], 45); ?>
            <?php endif; ?>
            </div>
            <div class="tags">
            <p><strong>Use:</strong>
              <a href="<?php echo uri('solr-search/results/?solrfacet=tag:' . $tag['value']); ?>"> <?php echo $tag['value']; ?></a>
            </p>
            <?php echo plugin_append_to_items_browse_each(); ?>
          </div><!-- end .item-entry -->
        </div>
        <?php endforeach; ?>

        <div class="grid_12 clearfix pagination bottom">
          <?php echo pagination_links(array('partial_file' => 'overrides/pagination_control.php')); ?>
        </div>
      <?php echo plugin_append_to_items_browse(array('anchor' => 'item_view')); ?>
      <?php else: ?>
          <div class='grid_9' id='no-results'>
            <h3>No results...</h3>
            <div><a href="./" id="start-over">Start Over</a></div>
          </div>
      <?php endif; ?>
    <!-- end #item_view -->
    </div>
</div>

<?php startFooterScript(); ?>
            <script>
            jQuery(function() {
                Proj4js.defs["EPSG:32618"] = "+proj=utm +zone=18 +ellps=WGS84 +datum=WGS84 +units=m +no_defs";
                var url = window.location.href
                    .replace('#' + window.location.href.hash, '');
                var map = browse_map('map_browser');

                $.getJSON(url, function(data) {
                    var markers = add_search_item(
                        data.docs,
                        {url: '<?php echo img('marker.png'); ?>'},
                        'EPSG:900913'
                    );
                    map.addLayer(markers);
                });
            });
             </script>
 
<?php endFooterScript(); ?>

<?php render('footer'); ?>


