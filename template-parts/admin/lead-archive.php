<div class="wrap">

   <h2><?php _e( 'Leads', 'glasbestellen' ); ?></h2>

   <?php $table = new Leads_Table(); ?>

   <form method="get">
      <?php $table->search_box( __( 'Zoek', 'glasbestellen' ), 'Leads_table_search_box' ); ?>
      <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
   </form>

   <form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
      <?php $table->display(); ?>
   </form>

</div>
