<?php
    $this->title = "A propos";
    $this->content =
    "<h1> A Propos </h1>
    <h2> Groupe 28 </h2>
    <ul>
        <li> Matéo   DUCASTEL 22009118 </li>
        <li> Théo    CRAUFFON 22009146 </li>
        <li> Nicolas LACAILLE 22011564 </li>
        <li> David   LIN      22010959 </li>
    </ul>

    <h2> Compléments réalisés </h2>
    <ul>
        <li> (*) Une recherche d'objets                                                                                       </li>
        <li> (*) Un objet peut être illustré par une image (et une seule, non modifiable) uploadée par le créateur de l'objet </li>
    </ul>

    <h2> Répartition des tâches </h2>
    <p>
        Matéo   a tout d'abord repris les TP avec notre nouveau sujet les Pokémons(nom, type, niveau, identifiant et si l'on souhaite une image).<br/>
        Nicolas s'est occupé quant à lui de la partie visuelle avec le css.<br/>
        David   a fait le complément de recherche qui permet dans la liste des Pokémons de rechercher par nom, type ou Niveau.<br/>
        Théo    a fait le complément sur les images et la page A Propos.
    </p>

    <h2> Design, modélisation... </h2>
    <p>
        - L'architecture de notre projet est bien l'architecture MVCR comme vous pourrez le constater. Nous avons bien séparer les différentes classes métier, de l'affichage...
        <br/> - Les pages générées sont valides HTML5.
        <br/> - Nous avons bien trois comptes distincts :
        <ol>
            <li>
                <ul>
                    <li> login        : vanier  </li>
                    <li> Mot de passe : toto    </li>
                </ul>
            </li>
            <br/>
            <li>
                <ul>
                    <li> login        : lecarpentier  </li>
                    <li> Mot de passe : toto          </li>
                </ul>
            </li>
            <br/>
            <li>
                <ul>
                    <li> login        : admin  </li>
                    <li> Mot de passe : toto    </li>
                </ul>
            </li>
        </ol>
        Le compte admin permet de modifier TOUS les pokémons
    </p>

    <p>
        Afin de configurer le site pour un serveur de la fac, il suffit de changer le nom de la base de données, le login ainsi que le mot de passe dans le fichier lib/ObjectFileDB.php aux lignes 142, 143 et 144. Dans ce fichier sur le git vous trouverez le nom de la bdd et le login de Théo Crauffon mais son mot de passe sera effacé.
    </p>
    ";
    $this->render();
?>
