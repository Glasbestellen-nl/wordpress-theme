<?php get_header(); ?>

   <main class="main-section main-section--space-around">

      <div class="container">

         <section class="page-header page-header--centered space-above">

            <h1 class="h1 page-header__headline page-header__headline--large"><?php _e( 'Oops.. Verkeerde afslag.', 'glasbestellen' ); ?></h1>
            <p class="large-space-below"><?php _e( 'Je bent naar een pagina geleid die niet bestaat. We helpen je graag de weg weer terug te vinden.', 'glasbestellen' ); ?></p>

            <p><a href="<?php echo home_url(); ?>" class="btn btn--primary btn--large btn--next"><?php _e( 'Homepage', 'glasbestellen' ); ?></a></p>

         </section>

      </div>

   </main>

<?php get_footer(); ?>
