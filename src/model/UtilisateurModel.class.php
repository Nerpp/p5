<?php
namespace App\model;

class UtilisateurModel
{
     
    // Méthodes
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

    public function gUserId(string $value)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("SELECT *
        FROM utilisateurs 
        LEFT JOIN clef ON utilisateurs.id_utilisateur = clef.utilisateurs_id_utilisateur 
        WHERE code_validation = :code_validation 
         OR email = :email");
        $req->bindValue(':email', $value, \PDO::PARAM_STR);
        $req->bindValue(':code_validation', $value, \PDO::PARAM_STR);
        $req->execute();
        $donnees = $req->fetch(\PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $donnees;   
    }
        
    public function grabCode(string $value)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("SELECT code_validation 
        FROM utilisateurs 
        WHERE email = :email 
        OR code_validation = :code_validation ");
        $req->bindValue(':email', $value, \PDO::PARAM_STR);
        $req->bindValue(':code_validation', $value, \PDO::PARAM_STR);
        $req->execute();
        $resultat = $req->fetch(\PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $resultat['code_validation'];
    }

    public function grabPseudo(string $value)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("SELECT pseudonyme 
        FROM utilisateurs 
        WHERE pseudonyme = :pseudonyme ");
        $req->bindValue(':pseudonyme', $value, \PDO::PARAM_STR);
        $req->execute();
        $resultat = $req->fetch(\PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $resultat['pseudonyme'];
    }

    public function searchPseudo(int $iId)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("SELECT pseudonyme 
        FROM utilisateurs 
        WHERE id_utilisateur = :id_utilisateur ");
        $req->bindValue(':id_utilisateur', $iId, \PDO::PARAM_INT);
        $req->execute();
        $resultat = $req->fetch(\PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $resultat['pseudonyme'];
    }

    public function valMail($sSearch, int $iValue)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("UPDATE utilisateurs 
        SET code_validation = $iValue 
        WHERE code_validation = :code_validation
        OR email = :email ");
        $req->bindValue(':email', $sSearch, \PDO::PARAM_STR);
        $req->bindValue(':code_validation', $sSearch, \PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }
    
    public function userSaving(string $pseudonyme, string $email, string $mdp,int $codeValidation)
    {
        $connection = $this->_aConnectionBdd->getConnection();
        $req = $connection->prepare('INSERT INTO utilisateurs (pseudonyme,email,mdp,code_validation) 
        VALUES(:pseudonyme,:email,:mdp,:codeValidation)');
        $req->bindValue(':pseudonyme', $pseudonyme, \PDO::PARAM_STR);
        $req->bindValue(':email', $email, \PDO::PARAM_STR);
        $req->bindValue(':mdp', $mdp, \PDO::PARAM_STR);
        $req->bindValue(':codeValidation', $codeValidation, \PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

    public function updatePass(string $sSearch,string $sValue)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("UPDATE utilisateurs 
        SET mdp = :mdp 
        WHERE email = :email
        ");
        $req->bindValue(':email', $sSearch, \PDO::PARAM_STR);
        $req->bindValue(':mdp', $sValue, \PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }
}
