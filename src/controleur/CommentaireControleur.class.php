<?php
namespace App\controleur;

class CommentaireControleur
{
    private $_aDisplay      = array();

    public function getDisplayErr()
    {
        return $this->_aDisplay;
    }

    public function __construct()
    {
        $this->_aInitSecurite          = new \App\module\securite;
        $this->_aInitCommentaireModel  = new \App\model\CommentaireModel;
    }

    public function recComment(string $sIdArticle, string $sComment)
    {
        if (!empty($_SESSION)){
            $sCommentSec = $this->_aInitSecurite->securiteString($sComment);
            if ($sCommentSec !== FALSE) {

                if (!$this->_aInitSecurite->controlLength($sCommentSec,255)) {
                    $this->_aDisplay['commentErr'] = 'Le nombre de caractéres est limités à 255';
                }else {
                    $this->_aInitCommentaireModel->recComment((int)$sIdArticle,$sCommentSec,(int)$_SESSION['id_utilisateur']);
                    $this->_aDisplay['commentErr'] = 'Votre Commentaire a été envoyé à la moderation';    
                }
            }else {
                $this->_aDisplay['commentErr'] = 'Veuillez écrire votre commentaire';
            }
        }else {
            $this->_aDisplay['commentErr'] = 'Vous devez être connecté pour commenter cet article';
        }
    }

    public function grabComment(int $iValue,string $sIndex)
    {
        return $this->_aInitCommentaireModel->grabComment($iValue,$sIndex);
    }

    public function grabUnallowedComment()
    {
        return $this->_aInitCommentaireModel->grabUnallowedComment();
    }

    public function statusComment(string $sComId, int $iStatut)
    {
        $this->_aInitCommentaireModel->statusComment($sComId,$iStatut);
    }

    public function delComment(string $sValue)
    {
        $this->_aInitCommentaireModel->delComment($sValue);
    }
}
