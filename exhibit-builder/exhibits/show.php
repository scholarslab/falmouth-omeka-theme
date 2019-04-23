<?php common('_header', array(
    'title' => html_escape(exhibit('title')),
    'articleclass' => "listing collection-listing") ); ?>

<div class="clearfix fullpage">
  <h1><?php echo link_to_exhibit(); ?></h1>

  <div class="grid_3 alpha navigation">
    <?php echo exhibit_builder_nested_nav(); ?>
  </div>

    <div class="grid_9">
    <h2 class="exhibit-page-header"><?php echo exhibit_page('title'); ?></h2>
   <?php exhibit_builder_render_exhibit_page(); ?>  
  </div>

</div>


<?php echo render('footer');

