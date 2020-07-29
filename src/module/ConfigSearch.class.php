<?php
namespace App\module;

class ConfigSearch
{
    private $_sNomBdd       = '';
    private $_sNomServeur   = '';
    private $_sNomRoot      = '';
    private $_sNomMdp       = '';
    private $_sUsername     = '';
    private $_sPassword     = '';
    private $_sMail         = '';
    private $_fileName      = 'config\config.txt';

    public function getMail()
    {
        return $this->_sMail;
    }

    public function getPassword()
    {
        return $this->_sPassword;
    }
    public function getUserName()
    {
        return $this->_sUsername;
    }

    public function getNomBdd()
    {
        return $this->_sNomBdd;
    }

    public function getNomServeur()
    {
        return $this->_sNomServeur;
    }

    public function getNomRoot()
    {
        return $this->_sNomRoot;
    }

    public function getNomMdp()
    {
        return $this->_sNomMdp;
    }

  

    public function configBdd()
    {

        if (file_exists($this->_fileName)) {
            $aData = file($this->_fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            $valueBdd = explode('=', $aData[1]);
            $this->_sNomBdd = trim($valueBdd[1]);

            $valueServeur = explode('=', $aData[2]);
            $this->_sNomServeur = trim($valueServeur[1]);

            $valueRoot = explode('=', $aData[3]);
            $this->_sNomRoot = trim($valueRoot[1]);

            $valueMdp = explode('=', $aData[4]);
            $this->_sNomMdp = trim($valueMdp[1]);
            
        } else {
            header('HTTP/1.1 404 Not Found');
            header('Location: vue\404.php');
            exit;
        }

       
    }

    public function configSmtp()
    {

        if (file_exists($this->_fileName)) {
            $aData = file($this->_fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            $valueUsername = explode('=', $aData[6]);
            $this->_sUsername = trim($valueUsername[1]);

            $valuePassword = explode('=', $aData[7]);
            $this->_sPassword = trim($valuePassword[1]);

        } else {
            header('HTTP/1.1 404 Not Found');
            header('Location: vue\404.php');
            exit;
        }
    }

    public function configMail()
    {
        if (file_exists($this->_fileName)) {
            $aData = file($this->_fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            $valueMail = explode('=', $aData[9]);
            $this->_sMail = trim($valueMail[1]);
            
        } else {
            header('HTTP/1.1 404 Not Found');
            header('Location: vue\404.php');
            exit;
        }   
    }
}
