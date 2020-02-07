<div class="choice__enlargement-image">
   <img src="<?php echo get_the_post_thumbnail_url( $_GET['part_id'] ); ?>" class="choice__enlargement-img"/>
</div>
<div class="choice__enlargement-body">
   <h3 class="h3 choice__enlargement-title"><?php echo get_the_title( $_GET['part_id'] ); ?></h3>
   <div class="text text-small choice__enlargement-description"><?php echo wpautop( get_the_excerpt( $_GET['part_id'] ) ); ?></div>
</div>
