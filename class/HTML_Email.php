<?php
class HTML_Email {

   private $html;

   public function __construct( string $template_path, array $data = [] ) {

      if ( empty( $template_path ) ) return;

      $this->generate_html_template( $template_path, $data );
   }

   /**
    * Generates the email html based on the given template and data
    */
   protected function generate_html_template( string $template_path, array $data = [] ) {

      if ( ! file_exists( $template_path ) ) return;

      ob_start();

      // Imports data from array into the current symbol table to use in template file
      if ( ! empty( $data ) ) extract( $data );

		include $template_path;
      $this->html = ob_get_contents();
      ob_end_clean();
      return true;
   }

   /**
    * Renders email html
    */
   public function render_html() {
      echo $this->html;
   }

   /**
    * Sends email with html as body
    */
   public function send( string $to = '', string $subject = '' ) {
      wp_mail( $to, $subject, $this->html, ['Content-Type: text/html; charset=UTF-8'] );
      return true;
   }

}
