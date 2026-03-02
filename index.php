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
use App\Database;

$conn = new Database();
$db = $conn->nadviazSpojenie();

if(!$db){
    die("Chyba spojenia s databazou!!");
}

$dom = new SmartHome();
$dom->nacitajZDatabazy($db);
$vysledokHladania = $dom->vypisVsetkyZariadenia();


if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["uloz_svetlo"])){
    $typ = "Svetlo";
    $stav = 0;

    $nazov = $_POST["nazov"];
    $miestnost = $_POST["miestnost"];
    $vyrobca = $_POST["vyrobca"];
    $intenzita = (int)$_POST["intenzita"];

    $sql = "INSERT INTO zariadenia (typ, nazov, miestnost, stav, vyrobca, specificky_parameter)
            VALUES (:typ, :nazov, :miestnost, :stav, :vyrobca, :specificky_parameter)";
    
    $stmt = $db->prepare($sql);

    $stmt->bindParam(":typ", $typ);
    $stmt->bindParam(":nazov", $nazov);
    $stmt->bindParam(":miestnost", $miestnost);
    $stmt->bindParam(":stav", $stav);
    $stmt->bindParam(":vyrobca", $vyrobca);
    $stmt->bindParam(":specificky_parameter", $intenzita);

    if($stmt->execute()){
        header("Location:index.php");
        exit();
    }
}

if(isset($_POST["prepni_stav"])){
    $id = $_POST["id_zariadenia"];
    $novyStav = $_POST["novy_stav"];

    $sql = "UPDATE zariadenia SET stav = :stav WHERE id = :id";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":stav", $novyStav);

    if($stmt->execute()){
        header("Location:index.php");
        exit();
    }

}



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
    
    <h3>Zariadenia v miestnosti: <u>Vsetky</u></h3>
    <div style="margin-top: 30px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h3>➕ Pridať nové Svetlo</h3>

        <form action="index.php" method="POST">
            <input type="text" name="nazov" placeholder="Názov (napr. Luster)" >
            <input type="text" name="miestnost" placeholder="Miestnosť" >
            <input type="text" name="vyrobca" placeholder="Výrobca" >
            <input type="number" name="intenzita" placeholder="Intenzita (0-100)" min="0" max="100" >
            <button type="submit" name="uloz_svetlo" style="background: #27ae60; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">
                Uložiť zariadenie
            </button>
        </form>

    </div><br>
    
    <table>
        <thead>
            <tr>
                <th>Zariadenie</th>
                <th>Typ</th>
                 <th>Miestnost</th>
                <th>Výrobca</th>
                <th>Stav</th>
                <th>Detail</th>
                <th>Akcia</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($vysledokHladania as $z): 
                    $idZariadenia = $z->getId();
                    $okamzityStav = ($z->getStav() === Zariadenie::STAV_ZAPNUTE) ? "Vypnúť 🔴" : "Zapnúť 🟢";
                    $novyStavZariadenia = ($z->getStav() === Zariadenie::STAV_ZAPNUTE)? Zariadenie::STAV_VYPNUTE : Zariadenie::STAV_ZAPNUTE;
                   
            ?>
                <tr>
                    <td><?= $z->getNazov(); ?></td>
                    <td><?= basename(get_class($z)); ?></td>
                    <td><?= $z->getMiestnost(); ?></td>
                    <td><?= $z->getVyrobca()->getInfo(); ?></td>
                    <td>
                        <?php if($z->getStav() === Zariadenie::STAV_ZAPNUTE): ?>
                            <span class="status-on">● ZAPNUTÉ</span>
                        <?php else: ?>
                            <span class="status-off">○ VYPNUTÉ</span>
                        <?php endif; ?>    
                    </td>
                    <td>
                        <?php 
                            if($z instanceof Svetlo){echo "Intenzita osvetlenia: ".$z->getIntenzita()."%"; }
                            if($z instanceof Termostat){
                                if($z->getStav() === Zariadenie::STAV_ZAPNUTE){
                                    echo "Teplota termostatu je nastavena na ".$z->getTeplota()."C"; 
                                }else{
                                    echo "Teplota termostatu je nastavena na 0C";
                                }
                            }
                            if($z instanceof Zaluzie){echo "Zaluzie su vytiahnute na ".$z->getVyskaVytiahnutia()."%"; }
                            if($z instanceof SenzorDymu){echo "Monitoring je aktivny"; }
                        ?>
                    </td>
                    <td>
                        <?php if($z instanceof Ovladatelne): ?>
                            <form action="index.php" method="POST">
                                <input type="hidden" name="id_zariadenia" value="<?= $idZariadenia; ?>">
                                <input type="hidden" name="novy_stav" value="<?= $novyStavZariadenia; ?>">

                                <button type="submit" name="prepni_stav">
                                    <?= $okamzityStav; ?>
                                </button>
                                <button type="submit" name="zmazZariadenie">
                                    <Span>Zmaz</Span>
                                </button>

                            </form>
                        <?php endif; ?>
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table> 
    <p>Celkový počet zariadení v dome: <strong><?= Zariadenie::getPocetZariadeni(); ?></strong></p>   
</body>
</html>

