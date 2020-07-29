<?php
namespace App\model;

class ArticleModel
{
    public function __construct()
    { 
        $aConfig = new \App\module\ConfigSearch;
        $aConfig->configBdd();
        $this->_aConnectionBdd = new \App\module\ConnectionBdd(  $aConfig->getNomServeur(), 
                                                                $aConfig->getNomBdd(),
                                                                $aConfig->getNomRoot(),
                                                                $aConfig->getNomMdp()
                                                            );
    }

    public function recArticle(string $sTitre,string $sChapo ,string $sArticle,int $iPublish ,int $iUser)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare('INSERT INTO articles (articles_titre,chapo,articles_contenu,articles_publier,utilisateurs_id_utilisateur) 
        VALUES(:articles_titre,:chapo,:articles_contenu,:articles_publier,:utilisateurs_id_utilisateur)');
        $req->bindValue(':articles_titre', $sTitre, \PDO::PARAM_STR);
        $req->bindValue(':articles_contenu', $sArticle, \PDO::PARAM_STR);
        $req->bindValue(':chapo', $sChapo, \PDO::PARAM_STR);
        $req->bindValue(':articles_publier', $iPublish, \PDO::PARAM_INT);
        $req->bindValue(':utilisateurs_id_utilisateur', $iUser, \PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }

    public function modArticle(string $sSearch,string $sTitle,string $sChapo,string $sArticle,string $sModDate,string $sModder)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("UPDATE articles 
        SET articles_titre = :articles_titre,
        chapo = :chapo,
        articles_contenu = :articles_contenu,
        date_modification = :date_modification,
        user_mod = :user_mod
        WHERE article_id = :article_id
        ");
        $req->bindValue(':article_id', $sSearch, \PDO::PARAM_STR);
        $req->bindValue(':articles_titre', $sTitle, \PDO::PARAM_STR);
        $req->bindValue(':chapo', $sChapo, \PDO::PARAM_STR);
        $req->bindValue(':articles_contenu', $sArticle, \PDO::PARAM_STR);
        $req->bindValue(':date_modification', $sModDate, \PDO::PARAM_STR);
        $req->bindValue(':user_mod', $sModder, \PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

    public function selAllArticle(int $iValue)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("SELECT *
        FROM articles
        WHERE articles_publier = :articles_publier 
        ORDER BY article_id DESC");
        $req->bindValue(':articles_publier', $iValue, \PDO::PARAM_INT);
        $req->execute();
        $resultat = $req->fetchAll(\PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $resultat;
    }
    
    public function selLastArticles(int $iValue)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("SELECT *
        FROM articles
        WHERE articles_publier = :articles_publier 
        ORDER BY article_id DESC
        LIMIT 3 ");
        $req->bindValue(':articles_publier', $iValue, \PDO::PARAM_INT);
        $req->execute();
        $resultat = $req->fetchAll(\PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $resultat;
    }

    public function selArticle(string $value)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("SELECT *
        FROM articles
        WHERE article_id = :article_id ");
        $req->bindValue(':article_id', $value, \PDO::PARAM_STR);
        $req->execute();
        $resultat = $req->fetchAll(\PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $resultat;
    }

    public function selTitle(string $value)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("SELECT articles_titre 
        FROM articles
        WHERE articles_titre = :articles_titre ");
        $req->bindValue(':articles_titre', $value, \PDO::PARAM_STR);
        $req->execute();
        $resultat = $req->fetchAll(\PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $resultat;
    }

    public function delArticle(string $value)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("DELETE
        FROM articles
        WHERE article_id = :article_id ");
        $req->bindValue(':article_id', $value, \PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }

    public function articleStatut(string $sSearch, int $iValue, string $sPublishingDate)
    {
        $req = $this->_aConnectionBdd->getConnection()->prepare("UPDATE articles 
        SET articles_publier = :articles_publier,
        articles_date_publication = :articles_date_publication
        WHERE article_id = :article_id
        ");
        $req->bindValue(':article_id', $sSearch, \PDO::PARAM_STR);
        $req->bindValue(':articles_date_publication', $sPublishingDate, \PDO::PARAM_STR);
        $req->bindValue(':articles_publier', $iValue, \PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }
}
