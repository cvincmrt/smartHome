<?php

namespace App;
use PDO;

class Vyrobca
{
    private string $meno;
    private string $podporaEmail;

    public function __construct($meno, $podporaEmail)
    {
        $this->meno = $meno;
        $this->podporaEmail = $podporaEmail;
    }

    public function getInfo()
    {
        return "{$this->meno} (kontakt: {$this->podporaEmail})";
    }
}