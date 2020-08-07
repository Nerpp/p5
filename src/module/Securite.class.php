<?php
namespace App\module;

class Securite
{
    // attributs
    private $_sClef              = '';
    private $_sIv                = '';
    private $_aParametres        = array();

    //getters
    public function getParametres()
    {
        return $this->_aParametres;
    }
    public function getIv()
    {
        return $this->_sIv;
    }
    public function getClef()
    {
        return $this->_sClef;
    }

    // methodes
    public function securiteUrl(){
        $securiteGet = filter_input_array(INPUT_GET);
        $securitePost = filter_input_array(INPUT_POST);
        if (isset($securiteGet) && count($securiteGet) > 0) {
            foreach ($securiteGet as $index => $valeur) {
                $this->_aParametres[$index] = $valeur;
            }
        } elseif (isset($securitePost) && count($securitePost) > 0) {
            foreach ($securitePost as $index => $valeur) {
                $this->_aParametres[$index] = $valeur;
            }
        }
    }

    public function passHash(string $value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    public function chiffrement(string $chiffrement)
    {    
            //        je definit la methode de chiffrement qui definit la longueur de l'iv et de la clé 
            $method = 'aes-256-cbc';
            //l'iv va definir la methode de chiffrement
            $this->_sIv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
            //la clef va permettre le dechiffrement
            $this->_sClef = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
            $resultat = openssl_encrypt ($chiffrement, $method, $this->_sClef, true, $this->_sIv);
            return $resultat;
    }

    public function dechiffrement(string $dechiffrement, string $clefDechiffrement, string $ivDechiffrement)
    {
            $method = 'aes-256-cbc';
            //        string openssl_decrypt ( string $data , string $method , string $password, option OPENSSL_RAW_DATA ou OPENSSL_ZERO_PADDING, $iv )
            $result = openssl_decrypt($dechiffrement, $method, $clefDechiffrement, true, $ivDechiffrement);
            return $result;
    }

    public function securiteMail(string $value)
    {
        if (!empty($value) && is_string($value)){
            trim($value);
            $value = filter_var($value, FILTER_SANITIZE_EMAIL);
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return $value;
            } else {
            return FALSE;}
        }else {
            return FALSE;
        } 
        
    }

    public function checkAuth(string $value)
    {
        
        if (isset($_SESSION['administrateur']) && $_SESSION['administrateur'] === '1') {
            return $value;
        }
        return '404';
    }

    public function pathAuth(string $value)
    {
      switch ($value) {

        case 'administrateur':
             return   $this->checkAuth($value);
            break;

            case 'Brouillon':
                return   $this->checkAuth('recDraft');
              break;
              
            case 'Publier':
                return   $this->checkAuth('publishArticle');
                break;
            
            case 'modifyArticle':
                return   $this->checkAuth($value);
                break;

            case 'recMod':
                return   $this->checkAuth($value);
                break;

            case 'statusArticle':
                return   $this->checkAuth($value);
                break;

            case 'deleteArticle':
                return   $this->checkAuth($value);
                break;

            case 'deleteComment':
                return $this->checkAuth($value);;
                break;

            case 'sendBack':
                return   $this->checkAuth($value);
                break;

            case 'delVisComment':
                return   $this->checkAuth($value);
                break;
          
          default:
              return $value;
              break;
      }
    }

    public function securiteString(string $value)
    {
        if (!empty($value) && is_string($value)) {
            $value = trim($value);
            $value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            return $value;
        }else {
            return FALSE;
        }
    }
    
    public function controlLength(string $sValue, int $iLength)
    {
        if (strlen($sValue) > $iLength) {
            return FALSE;
        }else {
            return TRUE;
        }
    }

    public function miniLength($sValue)
    {
        if (strlen($sValue) < 5) {
            return FALSE;
        }else {
            return TRUE;
        }
    }
}

