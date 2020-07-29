<?php
namespace App\model;

class CommentaireModel
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
    public function recComment(int $iIdArticle, string $sCommentSec,int $iIdUser)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare('INSERT INTO commentaires (commentaires_utilisateur,utilisateurs_id_utilisateur,id_articles) 
        VALUES(:commentaires_utilisateur,:utilisateurs_id_utilisateur,:id_articles)');
        $req->bindValue(':commentaires_utilisateur', $sCommentSec, \PDO::PARAM_STR_NATL);
        $req->bindValue(':utilisateurs_id_utilisateur', $iIdUser, \PDO::PARAM_INT);
        $req->bindValue(':id_articles', $iIdArticle, \PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

    public function grabComment(int $iValue,string $sIndex)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("SELECT *
        FROM commentaires
        WHERE commentaires_statut = :commentaires_statut
        AND id_articles = :id_articles");
        $req->bindValue(':commentaires_statut', $iValue, \PDO::PARAM_INT);
        $req->bindValue(':id_articles', $sIndex, \PDO::PARAM_STR);
        $req->execute();
        $resultat = $req->fetchAll(\PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $resultat;
    }

    public function grabUnallowedComment()
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("SELECT *
        FROM commentaires
        WHERE commentaires_statut = 0");
        $req->execute();
        $resultat = $req->fetchAll(\PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $resultat;
    }

    public function statusComment(string $sComId, int $iStatut)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("UPDATE commentaires 
        SET commentaires_statut = :commentaires_statut
        WHERE commentaires_id = :commentaires_id
        ");
        $req->bindValue(':commentaires_id', $sComId, \PDO::PARAM_STR);
        $req->bindValue(':commentaires_statut', $iStatut, \PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

    public function delComment(string $sValue)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("DELETE
        FROM commentaires
        WHERE commentaires_id = :commentaires_id ");
        $req->bindValue(':commentaires_id', $sValue, \PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }
}
