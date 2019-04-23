<?php
  common('_header', array(
    'title' => html_escape('Summary of ' . exhibit('title')))); ?>


<div class="clearfix fullpage">
  <h1><?php echo link_to_exhibit(); ?></h1>

  <div id="nav-container" class="grid_3 alpha">
    <?php 
      echo exhibit_builder_section_nav();
      echo exhibit_builder_page_nav();
    ?>
  </div>

  <div class="grid_9">
    <div class="exhibit-text">
      <h2><?php echo exhibit_page('title'); ?></h2>
    
      <p><?php echo nl2br(exhibit('description')); ?><p>
    
    </div>
  </div>
</div>

<?php render('footer');
