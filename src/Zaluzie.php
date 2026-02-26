<?php

namespace App;
use Exception;
use PDO;


class Zaluzie extends Zariadenie implements Ovladatelne
{
    private int $vyskaVytiahnutia;

    private static $pocetZaluzii = 0;

    public function __construct($nazov, $miestnost, $stav, $vyrobca, $vyska){
        parent::__construct($nazov, $miestnost, $stav, $vyrobca);
        $this->setVyska($vyska);

        self::$pocetZaluzii++;
    }

    public function setVyska($vyska)
    {
        if($vyska < 0 || $vyska > 100){
            throw new Exception("Vyska vytiahnutia zaluzii nadobuda hodnoty od 0 do 100!!!"); 
        }
        $this->vyskaVytiahnutia = $vyska;
    }

    public function vypni()
    {
        $this->stav = 0;
    }

    public function zapni()
    {
        $this->stav = 1;
    }

    public static function getPocetZaluzii()
    {
        return self::$pocetZaluzii;
    }

    public function getVyskaVytiahnutia()
    {
        return $this->vyskaVytiahnutia;
    }
}