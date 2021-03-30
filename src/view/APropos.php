<?php
    $this->title = "A propos";
    $this->content =
    "<h1> A Propos </h1>
    <h2> Décrivez-moi </h2>
    <ul>
        <li> Matéo   DUCASTEL 22009118 </li>
        <li> Théo    CRAUFFON 22009146 </li>
        <li> Nicolas LACAILLE 22011564 </li>
        <li> David   LIN      22010959 </li>
    </ul>

    <h2> Sujet de départ </h2>
    <ul>
        <li>
            In this project, a game should be developed where players have to annotate images as fast as possible.
            Further, the image to be annotated needs to be tagged (e.g. with the tags from flickr: <a href=\"https://www.flickr.com/photos/nemi1968/50248487398\">https://www.flickr.com/photos/nemi1968/50248487398</a>).
            The goal of the game is to match as many as possible tags in the shortest time. The quicker the answer, the more points you get! In addition,
            non-existing tags will be collected for further processing in order to enrich the corpus.
        </li>
    </ul>

    <h2> Fonctions à implémenter </h2>
    <ul>
        <li> Faire un site web permettant de jouer à un jeu </li>
        <li> Avoir la possibilité de s'inscrire et de se connecter </li>

        <li> Jouer une partie : </li>
        <ul>
            <li> La partie dure 1 minute </li>
            <li> L'objectif est de faire correspondre le plus de tags possible le plus vite </li>
            <li> Un tableau s'incrémente avec les tags correspondants et un autre avec les mauvais tags </li>
        </ul>

        <li> Le score est calculé en fonction de temps. Un tag trouvé au bout de 45 secondes va rapporter 45 points </li>
        <li> Au fur et à mesure de la partie, le score de l'utilisateur s'incrémente </li>
        <li> Un classement de tous les joueurs en fonction des points récoltés </li>
        <li> Le classement est hebdomadaire, il doit donc être réinitialisé tous les dimanches soir à miniut </li>

    </ul>

    <h2> Répartition des tâches </h2>
    <ul>
        <li> Matéo   s'est occupé de la partie des scores, allant de l'implémentation à la mise à jour au cours d'une partie, la page de profil. </li>
        <li> Nicolas s'est occupé quant à lui de la partie visuelle avec le css, de l'appel à l'api et de la partie du jeu en collaboration avec Théo. </li>
        <li> David   a fait le ReadMe.txt. </li>
        <li> Théo    a fait la base du projet (comptes, images, base de données, squelette...), le jeu avec Nicolas, le fichier date.js qui permet de faire le compte à rebours pour le jeu et celui du dimanche suivant et la page A Propos. </li>
    </ul>

    <h2> Design, modélisation... </h2>
    <p>
        - L'architecture de notre projet est bien l'architecture MVCR comme vous pourrez le constater. Nous avons bien séparer les différentes classes métier, de l'affichage...
        <br/> - Nous avons bien six comptes distincts :
        <ol>
            <li>
                <ul>
                    <li> login        : crauffon  </li>
                    <li> Mot de passe : toto    </li>
                </ul>
            </li>
            <br/>
            <li>
                <ul>
                    <li> login        : ducastel  </li>
                    <li> Mot de passe : toto          </li>
                </ul>
            </li>
            <br/>
            <li>
                <ul>
                    <li> login        : lacaille  </li>
                    <li> Mot de passe : toto          </li>
                </ul>
            </li>
            <br/>
            <li>
                <ul>
                    <li> login        : lin  </li>
                    <li> Mot de passe : toto          </li>
                </ul>
            </li>
            <br/>
            <li>
                <ul>
                    <li> login        : spaniol  </li>
                    <li> Mot de passe : admin          </li>
                </ul>
            </li>
            <br/>
            <li>
                <ul>
                    <li> login        : zanuttini  </li>
                    <li> Mot de passe : admin          </li>
                </ul>
            </li>
            <br/>
        </ol>
        Les comptes avec le mot de passe admin permetteront dans une prochaine version d'administrer le site.
    </p>

    <p>
        Afin de configurer le site pour un serveur de la fac, il suffit de changer le nom de la base de données, le login ainsi que le mot de passe dans le fichier lib/ObjectFileDB.php aux lignes 142, 143 et 144. Dans ce fichier sur le git vous trouverez le nom de la bdd et le login de Théo Crauffon mais son mot de passe sera effacé.
    </p>
    ";
    $this->render();
?>
