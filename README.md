# Projet-annuel_Decrivez-moi
Projet annuel en Licence 3 Informatique d'une durée d'un mois

Ce projet consiste en l'implémentation d'un jeu "Décrivez-moi", sous le langage de programmation PHP, JS et bases de données MySQL.

Notre groupe de projet avait donc pour but de développer un site web implémentant ce jeu.


Pour pouvoir jouer au jeu, il faudra tout d'abord s'inscrire en renseignant votre nom, votre prénom et un mot de passe.

Une fois inscrit, le jeu est jouable à une seule personne, cependant il vous est possible de regarder le classement des joueurs en fonction des points récoltés pendant les parties, afin de voir votre rang hebdomadaire. 
Ceci dit, le classement se réinitialise tous les dimanches soirs à minuit.

Le but du jeu est très simple, lorsque vous démarrez une partie:
	- une image apparaît à l'écran;
	- vous avez 60 secondes pour renseigner un maximum de tags afin de décrire l'image;
	- au bout des 60 secondes, vous ne pourrez plus saisir de tags;
	- passer à l'image suivant en appuyant sur un bouton prévu à cet effet, réinitialisant le compteur à 60 et démarrant une nouvelle partie avec une nouvelle image

Au cours d'une partie, vous pouvez voir le nombre de points que vous avez accumulé par bon tag renseigné, le gain de points est proportionnel au temps mis pour envoyer un tag correct (ex. tag envoyé 5 secondes après le début de la partie -> 60-5 = 55 points gagnés)
Il est également affiché les différents tableaux correspondant aux bons tags et aux mauvais, remplis au fur et à mesure que vous saisissez des tags.




Instructions pour accéder au jeu.

Pour commencer, vous devez décompresser le livrable avec un outil de décompression tel que WinRAR.

Avant de pouvoir accéder au site web, il vous faut ouvrir le fichier Router.php situé dans le répertoire src. 
Une fois dans ce fichier, modifier les différentes constantes "const" DB_ID, USER_ID, PASSWORD en renseignant respectivement le nom de la base de données utilisée pour le jeu dans le paramètre "dbname" de DB_ID, votre identifiant de connexion dans USER_ID, le mot de passe de votre base de données dans PASSWORD.
Après avoir apporté ces modifications, allez dans le répertoire model, ouvrez le fichier ImageStorageMySQL.php et décommenter "self::reinit()" dans le constructeur.
Faites de même avec le fichier AccountStorageMySQL.php dans le répertoire account.
Cela permet de créer les différentes tables dans votre base de données si c'est la première fois que vous utilisez notre site web.

Ensuite, saisissez dans l'URL de votre navigateur Web préféré: "https://dev-NUMETU.users.info.unicaen.fr/[répertoire où se trouve le livrable décompressé]"
Vous êtes maintenant sur le site web développé par notre équipe, il ne vous reste plus qu'à vous inscrire et à vous amuser!

