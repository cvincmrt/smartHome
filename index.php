<?php

require_once 'vendor/autoload.php'; 

use App\Zariadenie;
use App\Svetlo;
use App\Termostat;


try{
   $lampa = new Svetlo("Stolova lampa", "kuchyna",1,0);
   $kurenie = new Termostat("Radiator", "spalna", 1,25);
} catch(Exception $e){
    echo $e->getMessage();
}

$lampa->setStav(1);

var_dump($kurenie->getNazov(),$kurenie->getStav(),$kurenie->getTeplota() );

