<?php

namespace App;
use Exception;
use PDO;

class Termostat extends Zariadenie
{
    private int $teplota;

    public function __construct($nazov, $miestnost, $stav, $teplota)
    {
        parent::__construct($nazov, $miestnost, $stav);
        
        if($teplota < 0 || $teplota > 30){
            throw new Exception("Teplota môže nadobudať hodnoty od 0 do 30");
        }
        $this->teplota = $teplota;
    }

    public function getTeplota()
    {
        return $this->teplota;
    }

    public function setTeplota($teplota)
    {
        if($teplota < 0 || $teplota > 30){
            throw new Exception("Teplota môže nadobudať hodnoty od 0 do 30");
        }
        $this->teplota = $teplota;
    }
}