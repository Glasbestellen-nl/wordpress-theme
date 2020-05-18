<?php get_header(); ?>

   <?php
   if ( have_posts() ) {
      while ( have_posts() ) {
         the_post();
         ?>

         <main class="main-section main-section--space-around main-section--grey">

            <div class="container">

               <section class="layout">

                  <div class="layout__column box-shadow text">

                     <header class="large-space-below">
                        <?php the_title( '<h1>', '</h1>' ); ?>
                        <span class="h4"><?php _e( 'Veelgestelde vragen & antwoorden', 'glasbestellen' ); ?></span>
                     </header>

                     <?php
                     if ( get_field( 'faq_sections' ) ) {
                        $question_count = 0; ?>

                        <nav class="taggers large-space-below">
                           <?php while ( the_repeater_field( 'faq_sections' ) ) { ?>
                              <span class="tagger tagger--alt js-scroll-to" data-scroll-to="#section_<?php echo get_row_index(); ?>"><?php echo get_sub_field( 'faq_section_title' ); ?></span>
                           <?php } ?>
                        </nav>

                        <div class="large-space-below">

                           <?php while ( the_repeater_field( 'faq_sections' ) ) { ?>
                              <section class="large-space-below">
                                 <h3 class="h4"><?php echo get_sub_field( 'faq_section_title' ); ?></h3>
                                 <?php if ( get_sub_field( 'faq_section_questions' ) ) { ?>
                                    <ul>
                                    <?php while ( the_repeater_field( 'faq_section_questions' ) ) {
                                       $question_count ++; ?>
                                       <li><span class="link js-scroll-to" data-scroll-to="#question_<?php echo $question_count; ?>"><?php echo get_sub_field( 'question' ); ?></span></li>
                                    <?php } ?>
                                    </ul>
                                 <?php } ?>
                              </section>
                           <?php } ?>

                        </div>

                        <div>

                           <?php
                           $question_count = 0;
                           while ( the_repeater_field( 'faq_sections' ) ) { ?>
                              <section class="large-space-below" id="section_<?php echo get_row_index(); ?>">
                                 <h4 class="h2"><?php echo get_sub_field( 'faq_section_title' ); ?></h4>
                                 <?php if ( get_sub_field( 'faq_section_questions' ) ) { ?>
                                    <?php
                                    while ( the_repeater_field( 'faq_section_questions' ) ) {
                                       $question_count ++; ?>
                                       <article class="large-space-below" id="question_<?php echo $question_count; ?>">
                                          <h3 class="h5"><?php echo get_sub_field( 'question' ); ?></h3>
                                          <?php echo wpautop( ( get_sub_field( 'answer' ) ) ); ?>
                                       </article>
                                    <?php } ?>
                                 <?php } ?>
                              </section>
                           <?php } ?>

                        </div>

                     <?php } ?>

                  </div>

               </section>

            </div>

         </main>

      <?php } ?>

   <?php } ?>

<?php get_footer(); ?>
