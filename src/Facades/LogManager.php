<?php

   namespace Bzilee\MultichannelLog\Facades;

   use Illuminate\Support\Facades\Facade;

   class LogManager extends Facade
   {
       protected static function getFacadeAccessor()
       {
           return 'multichannel.log';
       }
   }