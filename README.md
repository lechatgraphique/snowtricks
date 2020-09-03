# P6_SnowTricks
Projet 5 de mon parcours Développeur d'application PHP/Symfony chez OpenClassrooms.  Créer un site collaboratif pour faire connaître ce sport auprès du grand public et aider à l'apprentissage des figures (tricks).

Installation

• Clonez ou téléchargez le repository GitHub :
• Configurez vos variables d'environnement tel que la connexion à la base de données dans le fichier .env.
• Téléchargez et installez les dépendances back-end du projet avec Composer : composer instal
• Créer un build d'assets (grâce à Webpack Encore) avec Npm : npm run build
• Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet : php bin/console doctrine:database:create
• Installer les fixtures pour avoir une démo de données fictives : php bin/console doctrine:fixtures:load

Félications le projet est installé correctement, vous pouvez désormais commencer à l'utiliser !
