<?php
class Email_Template_Builder {

   private $html;

   public function __construct( string $template_path, array $data = [] ) {

      if ( empty( $template_path ) ) return;

      $this->generate_template_html( $template_path, $data );
   }

   /**
    * Generates the email html based on the given template and data
    */
   protected function generate_template_html( string $template_path, array $data = [] ) {

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
    * Return the html
    */
   public function get_html() {
      return $this->html;
   }

}
