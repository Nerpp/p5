# p5

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/b591b65432a142b7aa790cd95e17169a)](https://app.codacy.com/manual/Nerpp/p5?utm_source=github.com&utm_medium=referral&utm_content=Nerpp/p5&utm_campaign=Badge_Grade_Dashboard)

# blogpersonnel

Etape 1
Cloner le repository dans votre dossier serveur

Etape 2
Ouvrer le dossier dans votre IDE, puis ouvrer votre terminal et taper composer install, pour installer les differents composants ensuite taper Composer update pour utiliser les dernieres versions des differents composants.

Etape 3
Une fois les composants de composer installé et updaté, taper npm install -g npm pour installer et updater les composants Node.js

Etape 4
Completer le fichier exempleConfigt.txt comme c'est indiquer dans le fichier

Etape 5
renommer le fichier exempleConfig.txt en config.txt

Etape 6
Ouvrer le phpAdmin de votre serveur et Importer la base de donnée selon le nom que vous lui aurez donné dans le fichier config.txt

Etape 7
Pour les droits administrateurs creez un compte ensuite allez dans la base de donnée et ouvrer la table utilisateurs. Une fois dans la table utilisateurs, dans la colonne ou votre compte est enregistré changé la valeur administrateur : 0 à 1.

Etape 8
Construisez les routes de l'autoload composer avec la commande composer dump-autoload --optimize
