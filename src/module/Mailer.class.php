<?php
namespace App\module;


class Mailer
{

    public function __construct()
    {
        $this->_aConfig                   = new \App\module\ConfigSearch;
    }

    public function envoitMail(string $title,string $mailClient,string $clientName,string $value)
    {
        $this->_aConfig->configSmtp();

        // Create the Transport
        $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
            ->setUsername($this->_aConfig->getUserName())
            ->setPassword($this->_aConfig->getPassword());

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message($title))
            ->setFrom(['wampkarl@gmailcom' => 'Karl'])
            ->setTo([$mailClient => $clientName])
            ->setBody($value);

        $socket = fsockopen('smtp.gmail.com', '465');
        if ($socket) {
            $mailer->send($message);
            return TRUE;
        } 
        return FALSE;
    }
}
