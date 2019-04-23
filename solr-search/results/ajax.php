<?php
/**
 * "Falmouth" Theme custom functions
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

<?php

$docs = array();
foreach ($results->response->docs as $doc) {
    $tag = $doc->getField('tag');
    $title = $doc->getField('title');

    $docArray = array(
        'id' => (int)$doc->id,
        'title' => $title['value'],
        'usage' => $tag['value'],
        'url' => uri('/items/show/' . $doc->id)
    );

    $image = $doc->getField('image');
    if ($image && count($image['value']) > 0) {
        $docArray['image_url'] = solr_search_image_path(
            'square_thumbnail',
            is_array($image['value']) ? $image['value'][0] : $image['value']
        );
    }

    $loc = $doc->getField('38_s');
    if ($loc) {
        $docArray['loc'] = $loc['value'];
    }

    array_push($docs, $docArray);
}

echo json_encode(array(
    'docs'  => $docs,
    'start' => $results->response->start,
    'count' => $results->response->numFound
));

?>


<?php
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>
