<?php

namespace App;
use Exception;
use PDO;

class Svetlo extends Zariadenie
{
    private int $intenzita;

    public function __construct($nazov, $miestnost, $stav, $intenzita)
    {
        parent::__construct($nazov, $miestnost, $stav);
        
        if($intenzita < 0 || $intenzita > 100){
            throw new Exception("Intenzita osvetlenia môže nadobudať hodnoty od 0 do 100");
        }
        $this->intenzita = $intenzita;
    }

    public function getIntenzita()
    {
        return $this->intenzita;
    }

    public function setIntenzita($intenzita)
    {
        if($intenzita < 0 || $intenzita > 100){
            throw new Exception("Intenzita osvetlenia môže nadobudať hodnoty od 0 do 100");
        }
        $this->intenzita = $intenzita;
    }
}