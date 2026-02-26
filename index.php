<?php

require_once 'vendor/autoload.php'; 

use App\Ovladatelne;
use App\SenzorDymu;
use App\Zariadenie;
use App\Svetlo;
use App\Termostat;
use App\Vyrobca;
use App\Zaluzie;
use App\SmartHome;

$samsung = new Vyrobca("Samsung", "support@samsung.sk");
$asus = new Vyrobca("Asus", "support@asus.sk");
$roma = new Vyrobca("Roma", "support@roma.com");


$dom = new SmartHome();

$dom->pridajZariadenie(new Svetlo("Stropne svetlo", "kuchyna",1, $asus,80));
$dom ->pridajZariadenie(new Termostat("Radiator","kupelna",0, $asus, 22));
$dom->pridajZariadenie(new SenzorDymu("Senzor", "chodba",1, $samsung));
$dom->pridajZariadenie(new Zaluzie("Ele.zaluzia", "kuchyna",1, $roma, 88));


/*
$miestnost = "kuchyna";
$vysledokHladania = $dom->najdiVsetkyZariadenia($miestnost);
*/
$vysledokHladania = $dom->vypisVsetkyZariadenia();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #2c3e50; color: white; }
        .status-on { color: #27ae60; font-weight: bold; }
        .status-off { color: #c0392b; font-weight: bold; }
        .badge { background: #3498db; color: white; padding: 3px 8px; border-radius: 12px; font-size: 0.8em; }
    </style>
</head>
<body>
    <h1>🏠 Smart Home Dashboard</h1>
    
    <h3>Zariadenia v miestnosti: <u><?= ucfirst($miestnost) ?></u></h3>
    
    <table>
        <thead>
            <tr>
                <th>Zariadenie</th>
                <th>Typ</th>
                <th>Výrobca</th>
                <th>Stav</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($vysledokHladania as $z): ?>
                <tr>
                    <td><?= $z->getNazov(); ?></td>
                    <td><?= basename(get_class($z)); ?></td>
                    <td><?= $z->getVyrobca()->getInfo(); ?></td>
                    <td>
                        <?php if($z->getStav() === Zariadenie::STAV_ZAPNUTIE): ?>
                            <span class="status-on">● ZAPNUTÉ</span>
                        <?php else: ?>
                            <span class="status-off">○ VYPNUTÉ</span>
                        <?php endif; ?>    
                    </td>
                    <td>
                        <?php 
                            if($z instanceof Svetlo){echo "Intenzita osvetlenia: ".$z->getIntenzita()."%"; }
                            if($z instanceof Termostat){
                                if($z->getStav() === Zariadenie::STAV_ZAPNUTIE){
                                    echo "Teplota termostatu je nastavena na ".$z->getTeplota()."C"; 
                                }else{
                                    echo "Teplota termostatu je nastavena na 0C";
                                }
                            }
                            if($z instanceof Zaluzie){echo "Zaluzie su vytiahnute na ".$z->getVyskaVytiahnutia()."%"; }
                            if($z instanceof SenzorDymu){echo "Monitoring je aktivny"; }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table> 
    <p>Celkový počet zariadení v dome: <strong><?= Zariadenie::getPocetZariadeni(); ?></strong></p>   
</body>
</html>

