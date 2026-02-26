<?php

namespace App;
use Exception;
use PDO;

class Svetlo extends Zariadenie implements Ovladatelne
{
    private int $intenzita;
    private static $pocetSvetiel = 0;

    public function __construct($nazov, $miestnost, $stav, $vyrobca, $intenzita)
    {
        parent::__construct($nazov, $miestnost, $stav, $vyrobca);
        
        $this->setIntenzita($intenzita);

        self::$pocetSvetiel++;
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

    public function zapni()
    {
        $this->setStav(1);
    }

    public function vypni()
    {
        $this->setStav(0);
    }
    
   public static function getPocetSvetiel(){
    return self::$pocetSvetiel;
   }
}