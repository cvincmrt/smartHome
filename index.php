<?php

require_once 'vendor/autoload.php'; 

use App\Ovladatelne;
use App\SenzorDymu;
use App\Zariadenie;
use App\Svetlo;
use App\Termostat;



$lampa = new Svetlo("Stropne svetlo", "kuchyna",1,100);
$kurenie = new Termostat("Radiator","kupelna",0,22);
$senzor =new SenzorDymu("Senzor", "chodba",1);

$dom = [$lampa, $kurenie, $senzor];

foreach($dom  as $zariadenie){
    echo "Zariadenie: ".$zariadenie->getNazov()." ---------------> Stav zariadenia: ".$zariadenie->getStav()."<br>";

    if($zariadenie instanceof Ovladatelne){
        $zariadenie->zapni();
        echo "Prave som to zariadenie zapol a stav zariadenia je ".$zariadenie->getStav();
    }else{
        echo "zariadenie sa neda ovladat";
    }
    echo "<br>";

}
  



