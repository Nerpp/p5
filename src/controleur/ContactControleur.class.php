<?php
namespace App\controleur;


class ContactControleur
{
    private $_aDisplay = array();


    public function getDisplay()
    {
        return $this->_aDisplay;
    }

    public function __construct()
    {
        $this->_aInitSecurite          = new \App\module\Securite;
        $this->_aMailer                = new \App\module\Mailer;
        $this->_aConfig                = new \App\module\ConfigSearch;
    }

    public function controlMail($aParam)
    {
        if (empty($_SESSION)) {
            $this->_aDisplay['messageErr'] = 'Vous devez être connecté pour envoyer votre message';
            return;
        }
        
        foreach ($aParam as $key => $value) {
            if ($key !== 'email') {
                $verifiedArray[$key] = $this->_aInitSecurite->securiteString($value);
            } else {
                $verifiedArray[$key] = $this->_aInitSecurite->securiteMail($value);
            }
        }

        $sMessage = $verifiedArray['prénom'].' '.$verifiedArray['nom']. ' à envoyé le message :'.$verifiedArray['message'];

        if (!in_array(FALSE, $verifiedArray)) {
            $this->_aConfig->configMail();
            $this->_aMailer->envoitMail('Contact Client',$this->_aConfig->getMail(), '', $sMessage);
        }else {
            $key = array_search(FALSE, $verifiedArray);
            $this->_aDisplay[$key.'Err'] = 'La valeur est incorrecte';

        }
    }
    
}
