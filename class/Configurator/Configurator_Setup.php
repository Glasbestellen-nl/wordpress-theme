<?php
namespace Configurator;

class Configurator_Setup {

   protected $type;

   protected $configurator_id;

   public static function get_instance( string $type = '', int $configurator_id = 0 ) {

      switch ( $type ) {
         case 'single-showerdoor' :
            return new Configurators\Showerdoor\Showerdoor( $configurator_id );
            break;
         case 'double-showerdoor' :
            return new Configurators\Showerdoor\Showerdoor( $configurator_id );
            break;
         case 'showerdoor-with-sidepanel-in-clamps' :
            return new Configurators\Showerdoor\With_Sidepanel( $configurator_id );
            break;
         case 'showerdoor-with-sidepanel-in-profile' :
            return new Configurators\Showerdoor\With_Sidepanel( $configurator_id );
            break;
         case 'showerdoor-on-sidepanel-in-clamps' :
            return new Configurators\Showerdoor\With_Sidepanel( $configurator_id );
            break;
         case 'showerdoor-on-sidepanel-in-profile' :
            return new Configurators\Showerdoor\With_Sidepanel( $configurator_id );
            break;
         default :
            return new Configurator( $configurator_id );
      }

   }

}
