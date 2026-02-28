<?php
namespace App;
use PDO;

class SmartHome
{
    private array $zariadenia = [];

    //pridanie zariadenia do systemu
    public function pridajZariadenie(Zariadenie $z)
    {
        $this->zariadenia[] = $z;
    } 

    //ziskanie vsetkych zariadeni
    public function getVsetky()
    {
        return $this->zariadenia;
    }

    //vypnut vsetko co sa vypnut da
    public function vypniVsetko()
    {
        foreach($this->zariadenia as $z)
        {
            if($z instanceof Ovladatelne)
            {
                $z->vypni();
            }
        }
    }

    //kolko svetiel je aktualne zapnutych
    public function getPocetZapnutychSvetiel()
    {
        $pocet = 0;
        foreach($this->zariadenia as $z)
        {
            if($z instanceof Svetlo && $z->getStav() === 1)
            {
                $pocet++;
            }
        }
        return $pocet;
    }

    //vypis vsetky zariadenia
    public function vypisVsetkyZariadenia()
    {
       $vysledok = [];
        foreach($this->zariadenia as $z){
            $vysledok[] = $z;
        }
        return $vysledok;
    }

    //najdi vsetky zariadenia v miestnosti
    public function najdiVsetkyZariadenia($miestnost)
    {
        $vysledok = [];
        foreach($this->zariadenia as $z){
            if($z->getMiestnost() === $miestnost){
                $vysledok[] = $z;
            }
        }
        return $vysledok;
    }

    //nacitaj data z databazy
    public function nacitajZDatabazy($db)
    {
        $sql ="SELECT * FROM zariadenia";
        
        $stmt = $db->query($sql);
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $z = null;

            $vyrobcaObj = new Vyrobca($row["vyrobca"], "support@$row[vyrobca].sk" );

            if($row["typ"] === "Svetlo"){
                $z = new Svetlo($row["nazov"], $row["miestnost"], (int)$row["stav"], $vyrobcaObj, (int)$row["specificky_parameter"]);
            }
             if($row["typ"] === "Termostat"){
                $z = new Termostat($row["nazov"], $row["miestnost"], (int)$row["stav"], $vyrobcaObj, (int)$row["specificky_parameter"]);
            }
             if($row["typ"] === "Zaluzie"){
                $z = new Zaluzie($row["nazov"], $row["miestnost"], (int)$row["stav"], $vyrobcaObj, (int)$row["specificky_parameter"]);
            }
             if($row["typ"] === "SenzorDymu"){
                $z = new SenzorDymu($row["nazov"], $row["miestnost"], (int)$row["stav"], $vyrobcaObj);
            }

            if($z !== null){
                $this->pridajZariadenie($z);
            }
            
        }

        
    }
}