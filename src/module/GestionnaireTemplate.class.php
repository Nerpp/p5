<?php
namespace App\module;


class GestionnaireTemplate
{

    private $_rBuildTwig;

    public function __construct()
    {
        //test
        $loader = new \Twig\Loader\FilesystemLoader('vue');
        $twig = new \Twig\Environment($loader, [
            'cache' => 'tmp', //'tmp',
            //'debug' => true,
        ]);
       
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addExtension(new \App\module\MesExtensions());
        $this->_rBuildTwig = $twig;
    }


    public function adminView(string $path, array $param)
    {
        $this->_rBuildTwig->addGlobal('session', $_SESSION);
        $this->_rBuildTwig->addGlobal('current_page', $path);
        print_r($this->_rBuildTwig->render($path . '.twig', $param), FALSE);
    }
    
}
