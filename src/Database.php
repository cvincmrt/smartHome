<?php

namespace App;
use PDO;



class Database
{
    private string $host = "localhost";
    private string $user = "root";
    private string $db_name = "smarthome";
    private string $pass = "";

    private string $charset = "utf8";
    public $spojenie;


    public function nadviazSpojenie()
    {
        $this->spojenie = null;

        try{
            $this->spojenie = new PDO("mysql:host=$this->host;dbname=$this->db_name;charset=$this->charset",$this->user, $this->pass);
            echo "databaza je pripojena";
        }catch(\PDOException $e){
            echo "databazu sa nepodarilo pripojit".$e->getMessage();
        }
        return $this->spojenie;

    }
}