<?php

namespace App\module;
//L'objet PDO est deja integrer dans PHP faut l'appeler
use \PDO;

class ConnectionBdd extends \PDO
{

    private $_rConnection;

    public function getConnection()
    {
        return $this->_rConnection;
    }
    //methodes

    public function __construct($nomServeur,$nomBdd,$root,$mdp)
    {
        $options = [
            PDO::MYSQL_ATTR_COMPRESS => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        $this->_rConnection = new \PDO('mysql:host=' . $nomServeur . ';dbname=' . $nomBdd . ';charset=utf8', $root, $mdp, $options);
    }

}//fin de la classe
