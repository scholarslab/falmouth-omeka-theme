<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <!-- www.phpied.com/conditional-comments-block-downloads/ -->
    <!--[if IE]><![endif]-->
    <title><?php echo settings('site_title');
        echo $title ? ' | ' . $title : ''; ?></title>

    <meta name="description" content="<?php echo settings('site_description')?>">
    <meta name="author" content="<?php echo settings('site_author');?>">

    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">

    <!-- Place favicon.ico and apple-touch-icon.png in the root of your domain and delete these references -->
    <link rel="shortcut icon" href="<?php echo src('favicon.ico', 'images'); ?>">
    <link rel="apple-touch-icon" href="<?php echo src('apple-touch-icon.png', 'images'); ?>">

    <!-- For the less-enabled mobile browsers like Opera Mini -->
    <?php //queue_css('handheld', 'handheld'); ?>
    <?php //display_css(); ?>
    <?php //echo stylesheet_link_tag('handheld'); ?>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/smoothness/jquery-ui.css" />
    <?php if($bodyclass == 'mapshow'): ?>
  <!-- GoogleMaps API -->
  <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAioVG4cScdJ2Csnny8hxlzRSnAuqtHousR0Y5t5y2T8eRy-zQJhS3vGXTkjQ9Zn0fbGPZUg64OIcxyA" type="text/javascript"></script>      
  <script src="http://openlayers.org/api/2.11/OpenLayers.js"></script>
<?php endif; ?>

  <?php echo javascript_include_tag('libs/modernizr-1.7.min, mylibs/script'); ?>

    <style type="text/css" scoped="scoped">
        .olControlLayerSwitcher .layersDiv {
            background-color: #c0c0c0;
        }
    </style>


    <!-- RSS link -->
    <?php echo auto_discovery_link_tag(); ?>
    
    <!-- Include plugin hooks -->
    <?php echo plugin_header(); ?>

    <!-- CSS: implied media="all" -->
    <?php echo stylesheet_link_tag('style_all'); ?>
</head>
<body <?php echo $bodyid ? ' id="' . $bodyid . '"' : '';?><?php echo $bodyclass ? ' class="'.$bodyclass.'"' : ''; ?>>
    <div id="page">
        <div id="wrapper" class="container_12 clearfix">
            <header id="header">
                <nav class="grid_12 alpha omega">
                    <ul id="navigation">
                         <?php echo public_nav(array(
                             'about' => uri('about'),
                             // 'browse' => uri('items'),
                             'browse' => uri('solr-search/results/?q=*%3A*'),
                             'essays'=>uri('exhibits/show/falmouth')
                             ));
                         ?>
                    </ul>
                </nav>

                <hgroup id="main-head" class="grid_8">
                    <h1><?php echo link_to_home_page(); ?> </h1>
                    <h2>Architecture and History</h2>
                </hgroup>
                <div id="head-search" class="grid_4">
                    <?php echo really_simple_search(); ?>
                </div>
            </header><!-- end header -->
            <div id="main" class="container_12">




