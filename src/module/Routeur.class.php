<?php
namespace App\module;

class Routeur
{
    private $_sCreationRoute    = '';
    private $_aParamRoute       = array();
    
    public function __construct()
    {
        $this->_aIniUtilisateurControleur = new \App\controleur\UtilisateurControleur;
        $this->_aIniArticleControleur     = new \App\controleur\ArticleControleur;
        $this->_aIniCommentaireControleur = new \App\controleur\CommentaireControleur;
        $this->_aIniSecurite              = new \App\module\Securite;
        $this->_aSession                  = new \App\module\Session;
        $this->_aControleContact          = new \App\controleur\ContactControleur;
    }


    public function setPath(){
        return $this->_sCreationRoute;
    }

    public function setParam(){
        return $this->_aParamRoute;
    }

    // methodes
    public function traitementUrl()
    {
        $this->_aIniSecurite->securiteUrl();
        return $this->_aIniSecurite->getParametres();
    }
    
    // gestion route
    public function traitementRoute(array $parametres)
    {
        $utilisateurControle = $this->_aIniUtilisateurControleur;
        $securite = $this->_aIniSecurite;
        
        $route = 'accueil';
        if (isset($parametres['p'])) {
            $route = $securite->securiteString($parametres['p']);
            $route = $securite->pathAuth($route);
        }

      

        switch ($route) {
            case 'deconnection' :
                $this->_aSession->sessionDestroy();
                $this->_aParamRoute['articles'] = $this->_aIniArticleControleur->showLastArticles(1);
                $this->_sCreationRoute = 'accueil';
                break;

            case 'accueil':
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $this->_sCreationRoute = 'accueil';
                break;

            case 'articles':
                $aLastArticles = $this->_aIniArticleControleur->showArticle(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $this->_sCreationRoute = 'articles';
                break;

            case 'cv':
                $this->_sCreationRoute = 'cv';
                break;

            case 'contact':
                $this->_sCreationRoute = 'contact';
                break;

            case 'connection':
                $this->_sCreationRoute = 'connection';
                break;
            
            case 'update' :
                $this->_sCreationRoute = 'update';
                break;
            
            case 'updateMdp':
                $utilisateurControle->cUserInput($parametres);
                $utilisateurControle->cMailUpdate();
                $utilisateurControle->cSendMail();
                $aDisplay = $utilisateurControle->getDisplayErr();
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $this->_aParamRoute = array_merge($parametres, $aDisplay);
                $this->_sCreationRoute = $utilisateurControle->getPath();
                break;
            
            case 'connectionUtilisateurs' :
                $utilisateurControle->cUserInput($parametres);
                $utilisateurControle->cMailCo();
                $utilisateurControle->cUserConnection();
                $aDisplay = $utilisateurControle->getDisplayErr();
                $this->_aParamRoute = array_merge($parametres, $aDisplay);
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $this->_sCreationRoute = $utilisateurControle->getPath();
                break;

            case 'inscription':
                $this->_sCreationRoute = 'inscription';
                break;

            case 'creationCompte':
                $utilisateurControle->cUserInput($parametres);
                $utilisateurControle->cAuthMail();
                $utilisateurControle->cPseudo();
                $utilisateurControle->cUserSaving();
                $utilisateurControle->cSendMail();
                $aDisplay = $utilisateurControle->getDisplayErr();
                $this->_aParamRoute = array_merge($parametres, $aDisplay);
                $this->_sCreationRoute = 'inscription';
                break;

            case 'validationMail':
                $utilisateurControle->cUserInput($parametres);
                $utilisateurControle->cAuthMail();
                $aDisplay = $utilisateurControle->getDisplayErr();
                $this->_aParamRoute = array_merge($parametres, $aDisplay);
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $this->_sCreationRoute = $utilisateurControle->getPath();
                break;

            case 'administrateur':
                $aLastDrafts = $this->_aIniArticleControleur->showArticle(0);
                $aAddDraftPseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastDrafts);
                $this->_aParamRoute['drafts'] = $aAddDraftPseudo;
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $addUserPseudo = $this->_aIniCommentaireControleur->grabUnallowedComment();
                $this->_aParamRoute['comment'] = $this->_aIniUtilisateurControleur->addPseudo($addUserPseudo);
                $this->_sCreationRoute = 'admin';
                break;

            case 'visual':
                $this->_aParamRoute['article'] = $this->_aIniArticleControleur->searchArticle($parametres['id']);
                $articleIndex = $this->_aParamRoute['article'][0];
                $articleIndex['articleCreator'] = $this->_aIniUtilisateurControleur->searchPseudo($articleIndex['utilisateurs_id_utilisateur']);
                $articleIndex['articleModder'] = $this->_aIniUtilisateurControleur->searchPseudo($articleIndex['user_mod']);
                $this->_aParamRoute['article'] = $articleIndex;
                $addUserPseudo = $this->_aIniCommentaireControleur->grabComment(1, $this->_aParamRoute['article']['article_id']);
                $this->_aParamRoute['commentaire'] = $this->_aIniUtilisateurControleur->addPseudo($addUserPseudo);
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $this->_sCreationRoute = 'visuel';
                break;

            case 'editeur':
                $this->_sCreationRoute = 'editeur';
                break;
            
            case 'recDraft':
                $this->_aIniArticleControleur->recArticle($parametres['titre'],$parametres['chapo'],$parametres['article'],0);
                $this->_aParamRoute['err'] = $this->_aIniArticleControleur->getDisplayErr();
                $this->_aParamRoute['display'] = $parametres;
                $aLastDrafts = $this->_aIniArticleControleur->showArticle(0);
                $aAddDraftPseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastDrafts);
                $this->_aParamRoute['drafts'] = $aAddDraftPseudo;
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $addUserPseudo = $this->_aIniCommentaireControleur->grabUnallowedComment();
                $this->_aParamRoute['comment'] = $this->_aIniUtilisateurControleur->addPseudo($addUserPseudo);
                $this->_sCreationRoute = $this->_aIniArticleControleur->getPath();
                break;

            case 'publishArticle':
                $this->_aIniArticleControleur->recArticle($parametres['titre'], $parametres['chapo'], $parametres['article'], 1);
                $this->_aParamRoute['err'] = $this->_aIniArticleControleur->getDisplayErr();
                $this->_aParamRoute['display'] = $parametres;
                $aLastDrafts = $this->_aIniArticleControleur->showArticle(0);
                $aAddDraftPseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastDrafts);
                $this->_aParamRoute['drafts'] = $aAddDraftPseudo;
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $addUserPseudo = $this->_aIniCommentaireControleur->grabUnallowedComment();
                $this->_aParamRoute['comment'] = $this->_aIniUtilisateurControleur->addPseudo($addUserPseudo);
                $this->_sCreationRoute = $this->_aIniArticleControleur->getPath();
                break;
             
            case 'modifyArticle':
                $this->_aParamRoute['mod'] = $this->_aIniArticleControleur->searchArticle($parametres['articlesId']);
                $aIndex = $this->_aParamRoute['mod'][0];
                $this->_aParamRoute['mod'] = $aIndex;
                $this->_sCreationRoute = 'modification';
                break;

            case 'recMod':
                $this->_aIniArticleControleur->modArticle($parametres['articleId'],$parametres['titre'],$parametres['chapo'],$parametres['article']);
                $aLastDrafts = $this->_aIniArticleControleur->showArticle(0);
                $aAddDraftPseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastDrafts);
                $this->_aParamRoute['drafts'] = $aAddDraftPseudo;
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $addUserPseudo = $this->_aIniCommentaireControleur->grabUnallowedComment();
                $this->_aParamRoute['comment'] = $this->_aIniUtilisateurControleur->addPseudo($addUserPseudo);
                $this->_sCreationRoute = 'admin';
                break;
            
            case 'statusArticle' :
                $this->_aIniArticleControleur->articleStatut($parametres['articlesId']);
                $aLastDrafts = $this->_aIniArticleControleur->showArticle(0);
                $aAddDraftPseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastDrafts);
                $this->_aParamRoute['drafts'] = $aAddDraftPseudo;
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $addUserPseudo = $this->_aIniCommentaireControleur->grabUnallowedComment();
                $this->_aParamRoute['comment'] = $this->_aIniUtilisateurControleur->addPseudo($addUserPseudo);
                $this->_sCreationRoute = 'admin';
                break;
            
            case 'deleteArticle' ;
                $this->_aIniArticleControleur->delArticle($parametres['articlesId']);
                $aLastDrafts = $this->_aIniArticleControleur->showArticle(0);
                $aAddDraftPseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastDrafts);
                $this->_aParamRoute['drafts'] = $aAddDraftPseudo;
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $addUserPseudo = $this->_aIniCommentaireControleur->grabUnallowedComment();
                $this->_aParamRoute['comment'] = $this->_aIniUtilisateurControleur->addPseudo($addUserPseudo);
                $this->_sCreationRoute = 'admin';
                break;

            case 'recComment':
                $this->_aParamRoute['article'] = $this->_aIniArticleControleur->searchArticle($parametres['id']);
                $articleIndex = $this->_aParamRoute['article'][0];
                $this->_aParamRoute['article'] = $articleIndex;
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $this->_aParamRoute['user'] = $this->_aIniUtilisateurControleur->searchPseudo($this->_aParamRoute['article']['utilisateurs_id_utilisateur']);
                $this->_aIniCommentaireControleur->recComment($parametres['id'],$parametres['commentaire']);
                $this->_aParamRoute['display'] = $this->_aIniCommentaireControleur->getDisplayErr();
                $addUserPseudo = $this->_aIniCommentaireControleur->grabComment(1, $this->_aParamRoute['article']['article_id']);
                $this->_aParamRoute['commentaire'] = $this->_aIniUtilisateurControleur->addPseudo($addUserPseudo);
                $this->_sCreationRoute = 'visuel';
                break;

            case 'allowComment':
                $aLastDrafts = $this->_aIniArticleControleur->showArticle(0);
                $aAddDraftPseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastDrafts);
                $this->_aParamRoute['drafts'] = $aAddDraftPseudo;
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $this->_aIniCommentaireControleur->statusComment($parametres['commentaireId'], 1);
                $addUserPseudo = $this->_aIniCommentaireControleur->grabUnallowedComment();
                $this->_aParamRoute['comment'] = $this->_aIniUtilisateurControleur->addPseudo($addUserPseudo);
                $this->_sCreationRoute = 'admin';
                break;

            case 'deleteComment':
                $aLastDrafts = $this->_aIniArticleControleur->showArticle(0);
                $aAddDraftPseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastDrafts);
                $this->_aParamRoute['drafts'] = $aAddDraftPseudo;
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $this->_aIniCommentaireControleur->delComment($parametres['commentaireId']);
                $addUserPseudo = $this->_aIniCommentaireControleur->grabUnallowedComment();
                $this->_aParamRoute['comment'] = $this->_aIniUtilisateurControleur->addPseudo($addUserPseudo);
                $this->_sCreationRoute = 'admin';
                break;

            case 'sendBack':
                $this->_aParamRoute['article'] = $this->_aIniArticleControleur->searchArticle($parametres['articleId']);
                $articleIndex = $this->_aParamRoute['article'][0];
                $this->_aParamRoute['article'] = $articleIndex;
                $this->_aIniCommentaireControleur->statusComment($parametres['commentaireId'], 0);
                $addUserPseudo = $this->_aIniCommentaireControleur->grabComment(1, $this->_aParamRoute['article']['article_id']);
                $this->_aParamRoute['commentaire'] = $this->_aIniUtilisateurControleur->addPseudo($addUserPseudo);
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $this->_sCreationRoute = 'visuel';
                break;

            case 'delVisComment':
                $this->_aParamRoute['article'] = $this->_aIniArticleControleur->searchArticle($parametres['articleId']);
                $articleIndex = $this->_aParamRoute['article'][0];
                $this->_aParamRoute['article'] = $articleIndex;
                $this->_aIniCommentaireControleur->delComment($parametres['commentaireId']);
                $addUserPseudo = $this->_aIniCommentaireControleur->grabComment(1, $this->_aParamRoute['article']['article_id']);
                $this->_aParamRoute['commentaire'] = $this->_aIniUtilisateurControleur->addPseudo($addUserPseudo);
                $aLastArticles = $this->_aIniArticleControleur->showLastArticles(1);
                $aAddpseudo = $this->_aIniUtilisateurControleur->addPseudo($aLastArticles);
                $this->_aParamRoute['articles'] = $aAddpseudo;
                $this->_sCreationRoute = 'visuel';
                break;

            case 'contactAdmin':
                $this->_aControleContact->controlMail($parametres);
                $this->_aParamRoute['display'] = $this->_aControleContact->getDisplay();
                $this->_sCreationRoute = 'contact';
                break;

            default:
                 $this->_sCreationRoute = '404';
                break;
        }
    }
    
}
