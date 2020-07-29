<?php
namespace App\model;

class KeyModel
{
    public function __construct()
    {
        $aConfig = new \App\module\ConfigSearch;
        $aConfig->configBdd();
        $this->_aConnectionBdd = new \App\module\ConnectionBdd(
                                                                $aConfig->getNomServeur(),
                                                                $aConfig->getNomBdd(),
                                                                $aConfig->getNomRoot(),
                                                                $aConfig->getNomMdp()
                                                            );
    }

    public function keySaving(string $getIv, string $getKey, string $foreignKey)
    {
        $connection = $this->_aConnectionBdd->getConnection();
        $req = $connection->prepare('INSERT INTO clef (clef_cle,clef_iv,utilisateurs_id_utilisateur) 
        VALUES(:clef_cle,:clef_iv,:utilisateurs_id_utilisateur)');
        $req->bindValue(':clef_cle', $getKey, \PDO::PARAM_STR);
        $req->bindValue(':clef_iv', $getIv, \PDO::PARAM_STR);
        $req->bindValue(':utilisateurs_id_utilisateur', $foreignKey, \PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }
    public function updateKey(int $sSearch, string $sKey, string $sIv)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("UPDATE clef 
        SET clef_cle = :clef_cle, clef_iv = :clef_iv
        WHERE utilisateurs_id_utilisateur = :utilisateurs_id_utilisateur
        ");
        $req->bindValue(':utilisateurs_id_utilisateur', $sSearch, \PDO::PARAM_INT);
        $req->bindValue(':clef_cle', $sKey, \PDO::PARAM_STR);
        $req->bindValue(':clef_iv', $sIv, \PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

}
