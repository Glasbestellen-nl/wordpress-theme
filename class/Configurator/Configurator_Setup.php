<?php
namespace Configurator;

class Configurator_Setup {

   protected $type;

   protected $configurator_id;

   public static function get_instance( string $type = '', int $configurator_id = 0 ) {

      switch ( $type ) {
         case 'single-showerdoor' :
            return new Configurators\Showerdoor\Configurator( $configurator_id );
            break;
         case 'double-showerdoor' :
            return new Configurators\Showerdoor\Configurator( $configurator_id );
            break;
         case 'showerdoor-with-sidepanel-in-clamps' :
            return new Configurators\Showerdoor\Configurator( $configurator_id );
            break;
         case 'showerdoor-with-sidepanel-in-profile' :
            return new Configurators\Showerdoor\Configurator( $configurator_id );
            break;
         case 'showerdoor-on-sidepanel-in-clamps' :
            return new Configurators\Showerdoor\Configurator( $configurator_id );
            break;
         case 'showerdoor-on-sidepanel-in-profile' :
            return new Configurators\Showerdoor\Configurator( $configurator_id );
         case 'led-mirror' :
            return new Configurators\Mirror\Led_Mirror( $configurator_id );
            break;
         case 'door' :
            return new Configurators\Door\Configurator( $configurator_id );
            break;
      }

   }

}