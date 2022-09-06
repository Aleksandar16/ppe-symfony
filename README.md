# ppe-symfony (projet personnel encadré)
Projet symfony BTS-2 : Gestion des locations


Ce projet est un site internet permettant de gérer les inventaires des locations AirBnB.


Répartition des tâches :

Aleksandar Milenkovic -> Membre 1 (Connexion/Mot de passe oublié, Gestion des mandataires, Gestion des biens)
Shakeel Jeerooburkhan -> Membre 2 (Gestion des locataires, Gestion des locations)


Stack technique :
- HTML/CSS
- BOOTSTRAP
- PHP
- Symfony

Télécharger le projet :
- Cloner le projet (invite de commande):
  - git clone https://github.com/Aleksandar16/ppe-symfony.git
  - cd ppe-symfony
- Installer le projet :
  - npm install
  - npm run build
  - composer install
- Créer la base de données : php bin/console doctrine:database:create
  - nom de la base de données : ppe-symfony
  - Remplir la base de données : php bin/console doctrine:schema:update --dumpsql --force
  - Implémenter les données de test : php bin/console doctrine:fixtures:load
- Démarrer le projet : symfony serve -d




