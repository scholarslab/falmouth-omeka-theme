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
 * @version   $Id: custom.php 6669 2011-05-19 17:35:21Z err8n $
 * @link      http://www.scholarslab.org
 *
 * PHP version 5
 *
 */
?>

<?php

/**
 * Override the simple search provided in the core
 *
 * This function uses HTML5 'placeholder' element and removes the 'button' for
 * search.
 *
 * @param string $div Identifier if you're using jqueryui
 * @param string $tab Tab identifier. This defaults to the current value of the 
 * tab in the form.
 *
 * @return string Form for search
 */
function really_simple_search($div='', $tab=null)
{
    //$uri = uri('items/browse');
    $uri = solr_search_base_url();

    $query = solr_search_get_params(null, 'solrq', 'solrfacet');

    $formProperties['action'] = $uri . $div;
    $formProperties['method'] = 'get';
    $html  = '<form ' . _tag_attributes($formProperties) . ">\n";
    $html .= '<fieldset>' . "\n\n";
    $html .= __v()->formText(
        'solrq',
        $query['q'],
        array(
            'placeholder' => 'Search',
            'name'        => 'textinput',
            'class'       => 'textinput'
        ));
    $html .= __v()->formHidden('solrfacet', $query['facet']);

    $html .= '</fieldset>' . "\n\n";
    $html .= '</form>';

    return $html;
}

function stylesheet_link_tag($sources, $options = array(), $directory='css')
{
    foreach(explode(',', $sources) as $file){
        $href = src(trim($file), $directory, 'css');
        return "<link rel='stylesheet' type='text/css' href='$href'>\n";
    }
}

function isUrl($string)
{
    $pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
    return preg_match($pattern, $url);

}

function link_to_page($text, $page, $linkProperties = array())
{
    $linkProperties['href'] = uri(array('controller' => '', 'action' => $page));
    return "<a " . _tag_attributes($linkProperties) . ">$text</a>";
}

/**
 * Custom javascript include helper which allows a comma-separated list of
 * javascripts to include
 *
 * <?php javascript_include_tag('script, plugins'); ?>
 *
 * @param string $sources Comma separated list of javascript files, without .js
 * extension.  Specifying 'default' will load the default javascript files in
 * the $directory parameter.
 * @param string $dir The directory in which to look for javascript files.
 *  Recommended to leave the default value.
 */
function javascript_include_tag($sources, $directory="javascripts")
{
    // edge case for default;
    // TODO: refactor in to seperate function
    if($sources == "default") {

        // remove 'default' from $sources
        $sources = '';

        // read $directory
        $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir;

        $contents = DirectoryIterator($path);

        foreach ($contents as $fileinfo) {
           $pathinfo = pathinfo($fileinfo);

           if($pathinfo['extension'] == 'js') {
                $sources .= $fileinfo->getFilename() . ',';
           }
        }
    }

    foreach(explode(',', $sources) as $file){
        $href = src(trim($file), $directory, 'js');
        echo "<script type=\"text/javascript\" src=\"$href\"></script>\n";
    }
}

/**
 * Overrides head/foot functions with Rails-esque render function
 *
 * @see common()
 *
 * @param string $file Relative path to partial
 * @param array $vars
 * @return void
 *
 */

function render($file, $vars = array())
{
    $fname = "_" . $file;
    common($fname, $vars);
    return;
}

/**
 * Creates a list of links for removing each facet currently in the search set.
 *
 * @param array $index The index of element IDs to names.
 *
 * @return string The HTML for a list of links to remove each facet from the
 * search set.
 */
function falmouth_remove_facets($query, $index)
{
    $html = '';

    if ($query->isEmpty()) {
        $html .= '<li><b>ALL TERMS</b></li>';
    } else {
        $img = img('checkmark.gif');

        $q = $query->getQuery();
        if (strlen($q) > 0) {
            $link = $query->makeLinkRemoveQuery();
            $html .= falmouth_facet_li('Keyword', $q, $img, $link);
        }

        foreach ($query->getFacets() as $key => $label) {
            $category = falmouth_get_element_name($index, $key);
            $label = trim($label, '"');
            $link = $query->makeLinkRemoveFacet($key);
            $html .= falmouth_facet_li($category, $label, $img, $link);
        }
    }

    return $html;
}

/**
 * Creates the <LI> tag for the facet value and remove link.
 *
 * @param string $category The name of the facet category.
 * @param string $label The label for the facet.
 * @param string $src The src URL for the image.
 * @param string $link The link to remove the facet.
 *
 * @return string The LI element jfor the facet.
 */
function falmouth_facet_li($category, $label, $src, $link)
{
    $label = fix_date_range_label($label);
    $html = "<li><span class='facet-category'>$category</span> "
        . "<span class='facet-label'>$label</span> "
        . "<a class='facet-remove' href='$link'>X</a>"
        . "<img alt='checkmark' src='$src' />"
        . '</li>'
        ;
    return $html;
}

/**
 * Creates a link that adds a facet to the current Solr search set.
 *
 * @param string $facet The name of the facet to add.
 * @param string $label The label to use with the facet.
 *
 * @return string The URL for the link with the facet added.
 */
function falmouth_remove_facet($facet, $label)
{
    $url = falmouth_remove_facet_url($facet, $label);
    $rmLink = "<a class='facet-remove' href='$url'>X</a>";
    return $rmLink;
}

/**
 * Creates the URL to remove a facet.
 *
 * @param string $facet The facet to remove from the current query.
 * @param string $label The facet label to remove.
 *
 * @return string The current URL with the facet removed.
 */
function falmouth_remove_facet_url($facet, $label)
{
    $uri = solr_search_base_url();
    $params = solr_search_get_params();
    $q = $params['q'];
    $facets = $params['facet'];
    $params = explode(' AND ', $facets);
    $paramKey = "$facet:\"$label\"";

    $newFacets = array();
    foreach ($params as $param) {
        if ($param !== null && strlen($param) > 0 && $param != $paramKey) {
            array_push($newFacets, $param);
        }
    }

    $newParams = array();
    if ($q !== null && strlen($q) > 0) {
        $newParams['solrq'] = $q;
    }
    if (! empty($newFacets)) {
        $newParams['solrfacet'] = implode('+AND+', $newFacets);
    }

    return falmouth_make_url($uri, $newParams);
}

/**
 * This constructs a URL from a base, query parameters, and an optional fragement.
 *
 * @param string $base   The base URL to start from.
 * @param array  $params The parameters to append to the base.
 * @param string $frag   The fragment to append to the URL.
 *
 * @return string The full URL.
 */
function falmouth_make_url($base, $params, $frag)
{
    $url = $base;

    if (count($params) > 0) {
        ksort($params);
        $urlParams = array();
        foreach ($params as $key => $value) {
            array_push($urlParams, $key . '=' . html_escape($value));
        }
        $url .= '?' . implode('&', $urlParams);
    }

    if ($frag !== null && strlen($frag) > 0) {
        $url .= '#' . $frag;
    }

    return $url;
}

/**
 * Creates a link for adding a facet to the current Solr search set.
 *
 * @param string  $facet The name of the facet to add.
 * @param string  $label The label to use with the facet.
 * @param integer $count The number of items tagged with that facet.
 *
 * @return string The URL for the link with the facet added.
 */
function falmouth_add_facet($facet, $label, $count)
{
    $uri = solr_search_base_url();
    $params = solr_search_get_params();
    $q = $params['q'];
    $facets = $params['facet'];
    $html = '';

    if (strpos($facets, "$facet:\"$label\"") !== false) {
        $link = falmouth_remove_facet($facet, $label);
        $html .= "<span class='fn'><b>$label</b></span>$link";

    } else {
        $newParams = array();
        if ($q !== null && strlen($q) > 0) {
            $newParams['solrq'] = $q;
        }
        if (! empty($facets)) {
            $facets .= "+AND+$facet:\"$label\"";
        } else {
            $facets = "$facet:\"$label\"";
        }
        $newParams['solrfacet'] = $facets;

        $link = falmouth_make_url($uri, $newParams);
        $html .= "<span class='fn'>"
            . "<a href='$link'>$label</a></span> "
            . "<span class='fc'>$count</span>";
    }

    return $html;
}

/**
 * This takes an element name and returns a pretty version of it.
 *
 * This currently follows these rules:
 *  1. If the name contains an underscore, look up the name in the database;
 *  2. If the name is 'tag', replace it with 'Use'; and
 *  3. Otherwise, return the name with title-capitals.
 *
 * @param array  $index The index of element IDs to names.
 * @param string $name  The name to get the pretty version of.
 *
 * @return string The pretty name.
 */
function falmouth_get_element_name($index, $name)
{
    if (strpos($name, '_') !== false) {
        return solr_search_get_element_name($index, $name);
    } elseif ($name == 'tag') {
        return 'Use';
    } else {
        return ucwords($name);
    }
}


/**
 * This queues a footer script.
 *
 * @param $script string The script to add to the footer script queue. It 
 * should include the <script>...</script> tags.
 *
 * @return void
 */
function queueFooterScript($script)
{
    if (Zend_Registry::isRegistered('footerScripts')) {
        $queue = Zend_Registry::get('footerScripts');
    } else {
        $queue = array();
    }

    array_push($queue, $script);

    Zend_Registry::set('footerScripts', $queue);
}

/**
 * This starts a block to enqueue in the footer script.
 */
function startFooterScript()
{
    ob_flush();
    ob_start();
}

/**
 * This takes the footer script just defined and enqueues it.
 */
function endFooterScript()
{
    queueFooterScript(ob_get_clean());
    ob_end_clean();
}

/**
 * This echoes the footer scripts and clears the script queue.
 *
 * @return void
 */
function echoFooterScripts()
{
    if (! Zend_Registry::isRegistered('footerScripts')) {
        return;
    }
    $queue = Zend_Registry::get('footerScripts');

    echo implode($queue);

    Zend_Registry::set('footerScripts', null);
}

/**
 * This limits the text by the given number of words.
 *
 * If the text has too many words, it's truncated at $limit words and ellipses
 * ("...") are appended.
 *
 * @param string  $text  The text to truncate.
 * @param integer $limit The number of words to limit the text to.
 *
 * @return string The truncated text.
 */
function limit_text($text, $limit) {
    if (!$text || strlen(trim($text)) == 0) {
        $text = '';
    } elseif (strlen($text) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        if (count($pos) > $limit) {
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
    }
    return $text;
}

/**
 * This truncates a label by the given number of characters.
 *
 * If the text is too long, it's truncated and an ellipses character (U+2026) is appended, returning 
 * a string that is $width + 1 characters long.
 *
 * @param string  $label The label to truncate.
 * @param integer $width The maximum number of characters.
 *
 * @return string The truncated text.
 */
function truncate_label($label, $width) {
    if (strlen($label) > $width) {
        $label = substr($label, 0, $width) . '&#x2026;';
    }
    return $label;
}

/**
 * This fixes a date range label by splitting the dates and re-joining them 
 * with an N-dash.
 *
 * If this isn't a date range, this does nothing.
 *
 * @param string $label The label to fix up.
 *
 * @return string The fixed up label.
 */
function fix_date_range_label($label) {
    if (preg_match('/\d{4}\s+\d{4}/', $label)) {
        $dates = preg_split('/\s+/', $label);
        $label = implode('&ndash;', $dates);
    }

    return $label;
}
