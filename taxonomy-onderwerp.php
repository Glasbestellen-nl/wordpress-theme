<?php get_header(); ?>

   <main class="main-section main-section--grey">

      <div class="container">

         <?php
         if ( function_exists( 'yoast_breadcrumb' ) ) {
            yoast_breadcrumb( '<div class="breadcrumbs space-below">', '</div>' );
         }
         ?>

         <div class="row">

            <div class="col-12 col-lg-3">

               <nav class="side-nav">

                  <div class="side-nav__section">

                     <h2 class="side-nav__heading">Toepassingen</h2>

                     <ul class="side-nav__list">
                        <li class="side-nav__item">
                           <a href="#" class="side-nav__link">Dubbel glas</a>
                        </li>
                        <li class="side-nav__item">
                           <a href="#" class="side-nav__link">Driedubbel glas</a>
                        </li>
                        <li class="side-nav__item">
                           <a href="#" class="side-nav__link">Geslepen glas</a>
                        </li>
                     </ul>

                  </div>

                  <div class="side-nav__section">

                     <h2 class="side-nav__heading">Soorten glas</h2>

                     <ul class="side-nav__list">
                        <li class="side-nav__item">
                           <a href="#" class="side-nav__link">Dubbel glas</a>
                        </li>
                        <li class="side-nav__item">
                           <a href="#" class="side-nav__link">Driedubbel glas</a>
                        </li>
                        <li class="side-nav__item">
                           <a href="#" class="side-nav__link">Geslepen glas</a>
                        </li>
                     </ul>

                  </div>

               </nav>

            </div>

            <div class="col-12 col-lg-9">

               <div class="layout">

                  <div class="text layout__column">

                     <?php
                     echo '<h1 class="h1">' . single_term_title( '', false ) . '</h1>';
                     echo term_description();
                     ?>

                  </div>

               </div>

            </div>

         </div>

      </div>

   </main>

<?php get_footer(); ?>
