<?php get_header(); ?>

   <div class="hero hero--small">

      <div class="container">

         <div class="hero__body">

            <div class="hero__header text-center">
               <h1 class="h1 hero__title"><?php post_type_archive_title(); ?></h1>
            </div>

         </div>

      </div>

   </div>

   <main class="main-section main-section--space-around">

      <div class="container">

         <?php
         if ( $subjects = get_terms( 'taxonomy=onderwerp&hide_empty=0' ) ) {

            foreach ( $subjects as $subject ) { ?>

               <section class="section">

                  <h2 class="h2 h-underlined"><?php echo $subject->name; ?></h2>

                  <div class="row">

                     <?php
                     $articles = new WP_Query( [
                        'post_type' => 'artikel',
                        'tax_query' => [
                           'taxonomy' => $subject->term_id,
                        ],
                        'posts_per_page' => -1
                     ]);
                     if ( $articles->have_posts() ) {
                        while ( $articles->have_posts() ) {
                           $articles->the_post(); ?>

                           <div class="col-12 col-md-6 col-lg-4">

                              <article class="card">

                                 <div class="card__body">

                                    <h2 class="h3"><a class="card__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                                    <div class="text card__text">
                                       <p><?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>"><?php _e( 'Lees meer', 'glasbestellen' ); ?> &raquo;</a></p>
                                    </div>

                                 </div>

                              </article>

                           </div>

                        <?php } ?>

                     <?php } ?>

                  </div>

               </section>

            <?php } ?>

         <?php } ?>

      </div>

   </main>

<?php get_footer(); ?>
