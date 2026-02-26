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
}