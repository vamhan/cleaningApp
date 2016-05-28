<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
      class nusoap_lib{
          function Nusoap_lib(){
               require_once(str_replace("\\","/",APPPATH).'libraries/NuSOAP/lib/nusoap'.EXT); //If we are executing this script on a Windows server
          }
      }
?>