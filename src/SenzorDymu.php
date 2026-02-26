<?php

namespace App;
use PDO;

class SenzorDymu extends Zariadenie
{
    public function __construct($nazov, $miestnost, $stav, $vyrobca)
    {
        parent::__construct($nazov, $miestnost, $stav, $vyrobca);
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