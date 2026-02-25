<?php

namespace App;
use PDO;

class SenzorDymu extends Zariadenie
{
    public function __construct($nazov, $miestnost, $stav)
    {
        parent::__construct($nazov, $miestnost, $stav);
    }

    public function skontrolovatVzduch()
    {
        if($this->stav === 0){
            echo "Vsetko je v poriadku";
        }else{
            echo "Privolajte hasicov";
        }

    }
}