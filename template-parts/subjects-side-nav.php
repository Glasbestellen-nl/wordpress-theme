<?php if ( $subjects = get_terms( 'taxonomy=onderwerp&hide_empty=0&order=DESC' ) ) { ?>

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

               <ul class="side-nav__list js-side-nav-list d-none d-lg-block">

                  <?php
                  while ( $articles->have_posts() ) {
                     $articles->the_post();
                     $link_class = ( get_queried_object_id() == get_the_id() ) ? 'side-nav__link side-nav__link--current' : 'side-nav__link'; ?>

                     <li class="side-nav__item">
                        <a href="<?php the_permalink(); ?>" class="<?php echo $link_class; ?>"><?php the_title(); ?></a>
                     </li>

                  <?php } ?>

               </ul>

            <?php } ?>

         </div>

      <?php } ?>

   </nav>

<?php } ?>
