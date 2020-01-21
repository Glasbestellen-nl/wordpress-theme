<?php if ( $subjects = get_terms( 'taxonomy=onderwerp&hide_empty=0' ) ) { ?>

   <nav class="side-nav">

      <?php
      $count = 0;
      foreach ( $subjects as $subject ) {

         $count ++;

         $articles = new WP_Query([
            'post_type' => 'artikel',
            'tax_query' => [
               [
                  'taxonomy' => 'onderwerp',
                  'field'    => 'term_id',
                  'terms'    => $subject->term_id,
               ]
            ],
            'posts_per_page' => -1,
            'order' => 'ASC'
         ]);
         ?>

         <div class="side-nav__section">

            <h2 class="side-nav__heading js-side-nav-list-toggler"><?php echo $subject->name; ?></h2>

            <?php if ( $articles->have_posts() ) { ?>

               <ul class="side-nav__list d-none d-lg-block js-side-nav-list">

                  <?php
                  while ( $articles->have_posts() ) {
                     $articles->the_post(); ?>

                     <li class="side-nav__item">
                        <a href="<?php the_permalink(); ?>" class="side-nav__link"><?php the_title(); ?></a>
                     </li>

                  <?php } ?>

               </ul>

            <?php } ?>

         </div>

      <?php } ?>

   </nav>

<?php } ?>
