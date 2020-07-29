<?php
session_start([
    'cookie_lifetime' => 0,
]);
$directionFile = __DIR__ . "/vendor/autoload.php";
require_once $directionFile;

    // pour ajouter de nouvelle classe à l\'autoload composer dump-autoload --optimize
use App\module\{
    ConnectionBdd,
    Mailer,
    MesExtensions,
    Routeur,
    Securite,
    Session,
    ConfigSearch,
    GestionnaireTemplate
};

use App\controleur\{
    UtilisateurControleur,
    ArticleControleur,
    CommentaireControleur,
    ContactControleur
};

use App\model\{
    UtilisateurModel,
    KeyModel,
    CommentaireModel,
    ArticleModel
};

// initialisation des objets
$gestionRoute           = new \App\module\Routeur;
$displayView = new \App\module\GestionnaireTemplate;
//Routing
$parametres             = array();

// traitement des parametres
if ($gestionRoute->traitementUrl() !== NULL) {
    $parametres = $gestionRoute->traitementUrl();
}
$gestionRoute->traitementRoute($parametres);

$displayView->adminView($gestionRoute->setPath(), $gestionRoute->setParam());