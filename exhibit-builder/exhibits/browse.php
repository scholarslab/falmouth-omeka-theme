
<?php common('_header', array(
    'title' => html_escape('Browse Exhibits'),
    'articleclass' => "listing collection-listing") ); ?>

<style>
  .fullpage {
    margin: 15px;
    padding: 15px;
  }
  .fullpage h2 {
    padding-bottom: 15px;
  }
</style>


<div class="clearfix fullpage">
  <?php if(count($exhibits) > 0): ?>
     <?php while(loop_exhibits()): ?>
      <h2 class="list-item-title"><?php echo link_to_exhibit(); ?></h2>
      <p class="item-description"><?php echo exhibit('description'); ?></p>
     <?php endwhile; ?>
  <?php else: ?>
    <p>There are no exhibits. Check back later.</p>
  <?php endif; ?>
</div>

<?php render('footer');
