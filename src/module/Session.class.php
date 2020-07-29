<?php
namespace App\module;

class Session
{
    public function __construct()
    {
        $this->_aUserSession = &$_SESSION;

    }

    public function regenSession()
    {
        session_regenerate_id(true);

    }

    public function sessionUser(array $aValue)
    {
        foreach ($aValue as $index => $value) {
            $this->_aUserSession[$index] = $value;
        }
    }

    public function sessionDestroy()
    {
        $_SESSION = array();
        session_destroy();
    }
}
