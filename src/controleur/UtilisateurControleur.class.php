<?php
/**
 * @author
 * Class utilisateur controler 
 */
namespace App\controleur;

class UtilisateurControleur
{

    // attributs
    private $_bRoad         = TRUE;
    private $_aDisplay      = array();
    private $_aSecurite     = array();
    private $_sDirPath      = 'accueil';
    private $_iValidCode;

    // getter
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
        $this->_aInitSecurite          = new \App\module\Securite;
        $this->_aInitUtilisateurModel  = new \App\model\UtilisateurModel;
        $this->_aInitKeyModel          = new \App\model\KeyModel;
        $this->_aMailer                = new \App\module\Mailer;
        $this->_aSession               = new \App\module\Session;
        
    }

    public function cUserInput(array $parametres)
    {
        foreach ($parametres as $key => $valeur) {
            if($key !== 'mail'){
                $this->_aSecurite[$key] = $this->_aInitSecurite->securiteString($valeur);
            }else{
                $this->_aSecurite[$key] = $this->_aInitSecurite->securiteMail($valeur);  
            }
        }
        if (isset($this->_aSecurite['pseudonyme'])) {
            if ($this->_aSecurite['pseudonyme'] === FALSE) {
                array_push( $this->_aDisplay, $this->_aDisplay['pseudoErr'] = 'Veuillez renseigner votre pseudonyme');
                $this->_bRoad = FALSE;
            }elseif (!$this->_aInitSecurite->controlLength($this->_aSecurite['pseudonyme'], 20)) {
                array_push($this->_aDisplay, $this->_aDisplay['pseudoErr'] = 'Le nombre de caractéres est limité à 20');
                $this->_bRoad = FALSE;
            }
        }

        if (isset($this->_aSecurite['mail']) ) {
           
            if ($this->_aSecurite['mail'] === FALSE) {
                if ($this->_aSecurite['p'] === 'connectionUtilisateurs') {
                    array_push($this->_aDisplay, $this->_aDisplay['connectionErr'] = 'Votre identifiant ou votre mot de passe n\'est pas valide');
                }else {
                    array_push($this->_aDisplay, $this->_aDisplay['mailErr'] = 'Veuillez renseigner votre adresse mail');
                }
                $this->_bRoad = FALSE;
            }elseif (!$this->_aInitSecurite->controlLength($this->_aSecurite['mail'], 40)) {
                
                if ($this->_aSecurite['p'] === 'connectionUtilisateurs') {
                    array_push($this->_aDisplay, $this->_aDisplay['connectionErr'] = 'Votre identifiant ou votre mot de passe n\'est pas valide');
                } else {
                    array_push($this->_aDisplay, $this->_aDisplay['mailErr'] = 'Le nombre de caractéres est limité à 40');
                }
                $this->_bRoad = FALSE;
            }
        }
       
        if (isset($this->_aSecurite['password']) ) {
            if ($this->_aSecurite['password'] === FALSE) {
                array_push( $this->_aDisplay, $this->_aDisplay['passwordErr'] = 'Veuillez renseigner votre mot de passe');
                $this->_bRoad = FALSE;
            }elseif (!$this->_aInitSecurite->controlLength($this->_aSecurite['password'], 255)) {
                array_push( $this->_aDisplay, $this->_aDisplay['passwordErr'] = 'Le nombre de caractére est limité à 255');
                $this->_bRoad = FALSE;
            }elseif (!$this->_aInitSecurite->miniLength($this->_aSecurite['password'])) {
                 if ($this->_aSecurite['p'] === 'connectionUtilisateurs') {
                array_push($this->_aDisplay, $this->_aDisplay['connectionErr'] = 'Votre identifiant ou votre mot de passe n\'est pas valide');
            } else {
                array_push( $this->_aDisplay, $this->_aDisplay['passwordErr'] = 'Votre mot de passe doit comporter 6 caractéres minimum');
                array_push( $this->_aDisplay, $this->_aDisplay['passworConfirmdErr'] = 'Votre mot de passe doit comporter 6 caractéres minimum');
            }
            $this->_bRoad = FALSE;
            }
        }
       
        if (isset($this->_aSecurite['passwordConfirm'])) {
            if ($this->_aSecurite['passwordConfirm'] === FALSE) {
                array_push($this->_aDisplay, $this->_aDisplay['passwordConfirmErr'] = 'Veuillez renseigner votre mot de passe');
                $this->_bRoad = FALSE;
            } elseif (!$this->_aInitSecurite->controlLength($this->_aSecurite['passwordConfirm'], 255)) {
                array_push($this->_aDisplay, $this->_aDisplay['passwordConfirmErr'] = 'Le nombre de caractére est limité à 255');
                $this->_bRoad = FALSE;
            }
        }
       
        if(isset($this->_aSecurite['password']) && isset($this->_aSecurite['passwordConfirm']) ){
            if ($this->_aSecurite['passwordConfirm'] !== $this->_aSecurite['password']) {
                array_push( $this->_aDisplay, $this->_aDisplay['passwordErr'] = 'Le mot de passe est différent de sa confirmation');
                array_push( $this->_aDisplay, $this->_aDisplay['passworConfirmdErr'] = 'La confirmation du mot de passe est différent du mot de passe');
                $this->_bRoad = FALSE;
            }
        }       
    }

    public function cAuthMail()
    {
        if ($this->_bRoad !== FALSE) {
            $utilisateurModel = $this->_aInitUtilisateurModel;
            if (isset($this->_aSecurite['mail'])) {
                $sValue = $this->_aSecurite['mail'];
                $aCheckConfirm = $utilisateurModel->grabCode($sValue);
                if (strlen($aCheckConfirm) >> 1) {
                    array_push($this->_aDisplay, $this->_aDisplay['mailErr'] = 'Un code de confirmation à déjà été envoyé à votre adresse mail');
                    array_push($this->_aDisplay, $this->_aDisplay['mailConfirmed'] = $sValue);
                    $this->_bRoad = FALSE;
                    $this->_sDirPath = 'inscription';
                } elseif (strlen($aCheckConfirm) === 1 && $aCheckConfirm !== Null) {
                    array_push($this->_aDisplay, $this->_aDisplay['mailErr'] = 'Cet email n\'est pas disponible');
                    $this->_bRoad = FALSE;
                    $this->_sDirPath = 'inscription';
                }elseif ($this->_aSecurite['p'] === 'validationMail' && $aCheckConfirm === Null) {
                    array_push($this->_aDisplay, $this->_aDisplay['confirmationMailErr'] = 'Ce mail est incorrect');
                    array_push($this->_aDisplay, $this->_aDisplay['mailErr'] = 'Cet email peut être enregistré');
                    $this->_bRoad = FALSE;
                    $this->_sDirPath = 'inscription';
                }
            }elseif (isset($this->_aSecurite['codeConfirmation'])) {
                $sValue = $this->_aSecurite['codeConfirmation'];
                $aCheckConfirm = $utilisateurModel->grabCode($sValue);
                if ($aCheckConfirm !== 1 && $aCheckConfirm !== Null) {
                    $aIdentity = $utilisateurModel->gUserId($sValue);
                    $this->_aSession->regenSession();
                    $this->_aSession->sessionUser($aIdentity);
                    $utilisateurModel->valMail($sValue, 1);
                    $this->_bRoad = TRUE;
                    $this->_sDirPath = 'accueil';
                }else{
                    array_push($this->_aDisplay, $this->_aDisplay['confirmationMailErr'] = 'Le code de validation est érroné');
                    $this->_bRoad = FALSE;
                    $this->_sDirPath = 'inscription';
                }
            }
        }
    }

    public function cMailUpdate()
    {
        if ($this->_aSecurite !== FALSE) {
            $utilisateurModel = $this->_aInitUtilisateurModel;
            $this->_sDirPath = 'update';
           
            if (isset($this->_aSecurite['mail'])) {
                
                $aCheckConfirm = $utilisateurModel->gUserId($this->_aSecurite['mail']);
                if (strlen($aCheckConfirm['code_validation']) >> 1 || $aCheckConfirm === FALSE) {
                    array_push($this->_aDisplay, $this->_aDisplay['connectionErr'] = 'Votre identifiant n\'est pas valide');
                    $this->_bRoad = FALSE;
                } else {
                    $this->_iValidCode = random_int(100000, 999999);
                    $utilisateurModel->valMail($aCheckConfirm['email'], $this->_iValidCode);
                    array_push($this->_aSecurite, $this->_aSecurite['pseudonyme'] = $aCheckConfirm['pseudonyme']);
                    array_push($this->_aDisplay, $this->_aDisplay['mailConfirmed'] = $this->_aSecurite['mail']);
                }
            }elseif (isset($this->_aSecurite['codeConfirmation'])) {
                $aIdentity = $utilisateurModel->gUserId($this->_aSecurite['codeConfirmation']);
               
                if (strlen($aIdentity['code_validation']) >> 1 && $aIdentity !== FALSE) {
                    $security = $this->_aInitSecurite;
                    $hashPass = $security->passHash($this->_aSecurite['passwordConfirm']);
                    $passEnc = $security->chiffrement($hashPass);
                    $utilisateurModel->updatePass($aIdentity['email'], $passEnc);
                    $getIv = $this->_aInitSecurite->getIv();
                    $getKey = $this->_aInitSecurite->getClef();
                    $this->_aInitKeyModel->updateKey((int)$aIdentity['id_utilisateur'],$getKey, $getIv);
                    $utilisateurModel->valMail($aIdentity['email'], 1);
                    $this->_aSession->regenSession();
                    $this->_aSession->sessionUser($aIdentity);
                    $this->_sDirPath = 'accueil';
                }else{
                    array_push($this->_aDisplay, $this->_aDisplay['connectionErr'] = 'Votre code d\'identification n\'est pas valide');
                }
                $this->_bRoad = FALSE;
            }

           
        }
    }

    public Function cMailCo()
    {
        if ($this->_bRoad !== FALSE) {
            $utilisateurModel = $this->_aInitUtilisateurModel;
            $aCheckConfirm = $utilisateurModel->grabCode($this->_aSecurite['mail']);
            if (strlen($aCheckConfirm) > 1 || $aCheckConfirm === NULL) {
                array_push($this->_aDisplay, $this->_aDisplay['connectionErr'] = 'Votre identifiant ou votre mot de passe n\'est pas valide');
                $this->_sDirPath = 'connection';
                $this->_bRoad = FALSE;
            }

        }
    }

    public function cPseudo(){
        if ($this->_bRoad !== FALSE) {
            $utilisateurModel = $this->_aInitUtilisateurModel;
            if ($utilisateurModel->grabPseudo($this->_aSecurite['pseudonyme']) !== NULL) {
                array_push( $this->_aDisplay, $this->_aDisplay['pseudoErr'] = 'Ce pseudonyme n\'est pas disponible');
                $this->_bRoad = FALSE; 
            }
        }
    }

    public function searchPseudo($iId)
    {
        if (!empty($iId)) {
            return  $this->_aInitUtilisateurModel->searchPseudo($iId);
        }else {
            return NULL;
        }
    }

    public function addPseudo($value)
    {
        
        if (!empty($value)) {
            for ($i = 0; $i < count($value); $i++) {
                if (!empty($value[$i]['utilisateurs_id_utilisateur'])) {
                    $value[$i]['pseudo'] =  $this->searchPseudo($value[$i]['utilisateurs_id_utilisateur']);

                }
                if (!empty($value[$i]['user_mod'])) {
                    $value[$i]['articleModder'] =  $this->searchPseudo($value[$i]['user_mod']);
                }
            }
        }
        return $value;
    }

    public function cUserSaving()
    {
        if ($this->_bRoad !== FALSE) {
            $security = $this->_aInitSecurite;
            $hashPass = $security->passHash($this->_aSecurite['passwordConfirm']);
            $passEnc = $security->chiffrement($hashPass);
            $this->_iValidCode = random_int(100000, 999999);
            $utilisateurModel = $this->_aInitUtilisateurModel;
            $utilisateurModel->userSaving($this->_aSecurite['pseudonyme'],$this->_aSecurite['mail'],$passEnc, $this->_iValidCode);
            $getIv = $this->_aInitSecurite->getIv();
            $getKey = $this->_aInitSecurite->getClef();
            $aForeignKey = $this->_aInitUtilisateurModel->gUserId($this->_aSecurite['mail']);
            $this->_aInitKeyModel->keySaving($getIv, $getKey,$aForeignKey['id_utilisateur']);
        }
    }

    public function cSendMail()
    {
        if ($this->_bRoad !== FALSE) {
        $custMessage = 'Bonjour ' . $this->_aSecurite['pseudonyme'] . ' le code de validation de votre adresse mail est le : ' . $this->_iValidCode;
        if (!$this->_aMailer->envoitMail('Confirmation de votre compte', $this->_aSecurite['mail'], $this->_aSecurite['pseudonyme'], $custMessage)) {
            array_push($this->_aDisplay, $this->_aDisplay['EnvoitMailErr'] = 'Un probléme est survenue lors de l\'envoie du mail de confirmation veuillez réessayer plus tard merci de votre compréhension');
            }else {
                array_push( $this->_aDisplay, $this->_aDisplay['mailConfirmed'] = $this->_aSecurite['mail']);
            }
        }
    }

    public function cUserConnection()
    {
        if ($this->_bRoad !== FALSE) {
            $aDataUser = $this->_aInitUtilisateurModel->gUserId($this->_aSecurite['mail']);
            
            if ($aDataUser !== FALSE) {
                $dechiffrement = $this->_aInitSecurite->dechiffrement($aDataUser['mdp'], $aDataUser['clef_cle'], $aDataUser['clef_iv']);
                $bPass = password_verify($this->_aSecurite['password'], $dechiffrement);
                if($bPass){
                    $this->_aSession->regenSession();
                    $this->_aSession->sessionUser($aDataUser);
                    $this->_sDirPath = 'accueil';          
                }else{
                    array_push($this->_aDisplay, $this->_aDisplay['connectionErr'] = 'Votre identifiant ou votre mot de passe n\'est pas valide');
                    $this->_bRoad = FALSE;
                    $this->_sDirPath = 'connection';
                }
            }else {
                array_push($this->_aDisplay, $this->_aDisplay['connectionErr'] = 'Votre identifiant ou votre mot de passe n\'est pas valide');
                $this->_bRoad = FALSE;
                $this->_sDirPath = 'connection';
            }
        }else {
            $this->_sDirPath = 'connection';
        }
    }
}
