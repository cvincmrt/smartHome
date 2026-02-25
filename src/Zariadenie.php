<?php
namespace App;
use Exception;
use PDO;

abstract class Zariadenie
{
    protected string $nazov;
    protected string $miestnost;
    protected int $stav;
   

    public function __construct($nazov, $miestnost, $stav)
    {
        $this->nazov = $nazov;
        $this->miestnost = $miestnost;

        if($stav != 0 && $stav != 1)
        {
            throw new Exception("Stav zariadenia môže nadobudat hodnotu 0, alebo 1");
        }
        $this->stav = $stav;
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
}