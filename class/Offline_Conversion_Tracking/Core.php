<?php
namespace Offline_Conversion_Tracking;

class Core {

   public function __construct() {
      $hooks = new Hooks;
      $data_pusher = new Data_Pusher;
   }

}
