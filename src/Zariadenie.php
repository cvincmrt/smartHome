<?php
namespace App;
use Exception;
use PDO;

abstract class Zariadenie
{
    public const STAV_ZAPNUTE = 1;
    public const STAV_VYPNUTE = 0;
    
    protected string $nazov;
    protected Vyrobca $vyrobca;
    protected string $miestnost;
    protected int $stav;
    private static int $pocet = 0;
   

    public function __construct($nazov, $miestnost, $stav, $vyrobca)
    {
        $this->nazov = $nazov;
        $this->vyrobca = $vyrobca;
        $this->miestnost = $miestnost;

        $this->setStav($stav);

        self::$pocet++;
    }

    public function getVyrobca()
    {
        return $this->vyrobca;
    }

    public function getNazov()
    {
        return $this->nazov;       
    }

    public function getMiestnost()
    {
        return $this->miestnost;       
    }

    public function getStav()
    {
        return $this->stav;
    }

    public function setStav($stav)
    {
        if($stav != 0 && $stav != 1)
        {
            throw new Exception("Stav zariadenia môže nadobudat hodnotu 0, alebo 1");
        }
        $this->stav = $stav;

    }

    public static function getPocetZariadeni(){
        return self::$pocet;
    }
}