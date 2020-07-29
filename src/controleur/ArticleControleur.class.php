<?php
namespace App\controleur;

class ArticleControleur
{
    private $_aDisplay      = array();
    private $_sDirPath      = 'accueil';

    public function getDisplayErr()
    {
        return $this->_aDisplay;
    }

    public function getPath()
    {
        return $this->_sDirPath;
    }

    public function __construct()
    {
        $this->_aInitSecurite          = new \App\module\securite;
        $this->_aIniArticleModel  = new \App\model\ArticleModel;
    }

    public function recArticle(string $sTitle,string $sChapo ,string $sArticle, int $iValue)
    {

        if (!empty($sTitle) && !empty($sChapo) && !empty($sArticle) ){

            $bControl = TRUE;

            if (!$this->_aInitSecurite->controlLength($sTitle, 100)) {
                array_push($this->_aDisplay, $this->_aDisplay['titleErr'] = '100 caractéres sont autorisé pour le titre');
                $this->_sDirPath = 'editeur';
                $bControl = FALSE;
            }

            if(!$this->_aInitSecurite->controlLength($sChapo, 65535))
            {
                array_push($this->_aDisplay, $this->_aDisplay['chapoErr'] = '167777215 caractéres sont autorisé pour le châpo');
                $this->_sDirPath = 'editeur';
                $bControl = FALSE;
            }

            if (!$this->_aInitSecurite->controlLength($sArticle, 16777215)) 
            {
                array_push($this->_aDisplay, $this->_aDisplay['articleErr'] = '167777215 caractéres sont autorisé pour le châpo');
                $this->_sDirPath = 'editeur';
                $bControl = FALSE;
            }

            if ($bControl !== TRUE) {
               return;
            }

            if(!empty($this->_aIniArticleModel->selTitle($sTitle))){
                array_push($this->_aDisplay, $this->_aDisplay['titleErr'] = 'Cet article existe déjà');
                array_push($this->_aDisplay, $this->_aDisplay['chapoErr'] = 'Vérifiez le châpo');
                array_push($this->_aDisplay, $this->_aDisplay['articleErr'] = 'Vérifiez le contenu l\'article');
                $this->_sDirPath = 'editeur';
        }else {
                $this->_aIniArticleModel->recArticle($sTitle,$sChapo,$sArticle,$iValue,(int) $_SESSION['utilisateurs_id_utilisateur']);
                $this->_sDirPath = 'admin';
        }

        }else {
            $this->_sDirPath = 'editeur';

            if (empty($sTitle)) {
                array_push($this->_aDisplay, $this->_aDisplay['titleErr'] = 'Veuillez renseigner le titre');
            }
            if (empty($sChapo)) {
                array_push($this->_aDisplay, $this->_aDisplay['chapoErr'] = 'Veuillez rédiger le châpo');
            }
            if (empty($sArticle)) {
                array_push($this->_aDisplay, $this->_aDisplay['articleErr'] = 'Veuillez rédiger l\'article');
            }
        }
    }

    public function modArticle(string $sSearch,string $sTitle, string $sChapo, string $sArticle)
    {
        $sModDate = date("Y-m-d H:i:s");
        $this->_aIniArticleModel->modArticle($sSearch,$sTitle, $sChapo, $sArticle, $sModDate,$_SESSION['id_utilisateur']);
    }

    public function showArticle($iValue)
    {
        return $this->_aIniArticleModel->selAllArticle($iValue);
    }
    
    public function showLastArticles($iValue)
    {
        return $this->_aIniArticleModel->selLastArticles($iValue);
    }

    public function searchArticle(string $value)
    {
        
        return $this->_aIniArticleModel->selArticle($value);
       
    }

    public function delArticle(string $value)
    {
        $this->_aIniArticleModel->delArticle($value);
    }

    public function articleStatut(string $sValue)
    {
        $sCheckingDate = $this->_aIniArticleModel->selArticle($sValue);

        if(!empty($sCheckingDate[0]['articles_date_publication'])){
            $sPublishingDate =  $sCheckingDate[0]['articles_date_publication'];
        }else{
            $sPublishingDate = date("Y-m-d H:i:s");
        }

        if ($sCheckingDate[0]['articles_publier'] === '1') {
            $iValue = 0 ;
        }else {
            $iValue = 1;
        }
        $this->_aIniArticleModel->articleStatut($sValue,$iValue,$sPublishingDate);
    }
}
