# Mediatekformation partie Admin
## Présentation
Ce site, développé avec Symfony 5.4, permet d'accéder à la modifications des formations , playlists et catégories.<br> 
## Les différentes pages
Voici les 4 pages correspondant aux différents cas d’utilisation.
### Page 1 : la Connexion 
Lorsque l'on tente d'acceder à la partie admin, une page de connexion s'ouvre nous demandant d'entrer un login et un mot de passe.

![img1](https://image.noelshack.com/fichiers/2024/09/4/1709231348-capture-d-ecran-2024-02-29-a-18-20-46.png)
### Page 2 : Admin Formation
Page accessible dans le menu en cliquant sur le nom "Admin Formations"
- Possibilité de tri croissant et decroissant des formations
- Filtre de recherche de formations
- Possibilité de tri croissant et decroissant des playlists liées aux formations
- Filtre de recherche de playlists liées aux formations
- Possibilité des tris par catégories
- Possibilité de tri croissant/décroissant par date de création
- Fonctionnialité ajout de formation

- Bouton Edition qui mène au formulaire d'édition de la formation
- Bouton de suppression

Liste de toutes les formations , avec leur playlists associés, catégories associées , date de parutions, miniature vidéos

![img2](https://image.noelshack.com/fichiers/2024/09/4/1709231757-capture-d-ecran-2024-02-17-a-22-14-55.png)


### Page 3 : Admin Playlists
Page accessible dans le menu en cliquant sur le nom "Admin Playlists"
- Possibilité de tri croissant et decroissant des playlists
- Filtre de recherche de playlists
- Possibilité de tri croissant et decroissant des playlists en fonction du nombre de formations dans la playlist
- Ajout de Playlists

- Bouton Edition qui mème au formulaire d'édition de la playlist
- Bouton de suppression

Liste de toutes les playlists , avec leur catégories associés, nombre de formations dans la playlist

![img2](https://image.noelshack.com/fichiers/2024/09/4/1709231352-capture-d-ecran-2024-02-29-a-18-19-44.png)




### Page 4 : Admin Catégorie
Page accessible dans le menu en cliquant sur le nom "Admin Catégories"
- Ajout de catégories
Noms des catégories placées en liste avec la possibilité de les supprimer grâce au bouton "supprimer" placés à coté de chaque catégorie.


![img3](https://image.noelshack.com/fichiers/2024/09/4/1709231355-capture-d-ecran-2024-02-29-a-18-20-33.png)



Le lien de déconnexion est présent sur toutes les pages.

## La base de données
La base de données exploitée par le site est au format MySQL.

## Installation de l'application
- Vérifier que Composer, Git et Wamserver (ou équivalent) sont installés sur l'ordinateur.
- Télécharger le code et le dézipper dans www de Wampserver (ou dossier équivalent) puis renommer le dossier en "mediatekformation".<br>
- Ouvrir une fenêtre de commandes en mode admin, se positionner dans le dossier du projet et taper "composer install" pour reconstituer le dossier vendor.<br>
- Récupérer le fichier mediatekformation.sql en racine du projet et l'utiliser pour créer la BDD MySQL "mediatekformation" en root sans pwd (si vous voulez mettre un login/pwd d'accès, il faut le préciser dans le fichier ".env" en racine du projet).<br>
- De préférence, ouvrir l'application dans un IDE professionnel. L'adresse pour la lancer est : http://localhost/mediatekformation/public/index.php<br>

## Le lien du site est :
https://mediatekformation.minty-dev-create.fr/

## Pour retrouver le readme de la partie front end :


https://github.com/CNED-SLAM/mediatekformation/blob/master/README.md
