<html>
    <body>

        <?php

        $dbhost = 'localhost:3307';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'nf92p018';
        $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
        //la ligne suivante permet d'éviter les problèmes d'accent entre la page web et le serveur mysql
        mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8

          $prenom =$_POST["prenom"];
          $nom=$_POST["nom"];
          $bdate=$_POST["bdate"];
          $valider=$_POST['valider'];

          date_default_timezone_set('Europe/Paris');
          $date = date("Y-m-d");

          if ($valider == 1){
            //si l'utilisateur a bien rempli son nom et son prénom alors on envoie les informations vers la BDD
            $query = "INSERT INTO eleves VALUES (NULL,"."'$nom'".","."'$prenom'".","."'$bdate'".","."'$date'".")";
            $result = mysqli_query($connect, $query);
            // $query utilise comme parametre de mysqli_query
            // le test ci-dessous est desormais impose pour chaque appel de :
            // mysqli_query($connect, $query)
            echo "<p>L'inscription a bien été prise en compte</p>";
            echo "<a href='ajout_eleve.html'>Retour</a>";
          }
          else{
            echo "<p>L'inscription a bien été annulée</p>";
            echo "<a href='ajout_eleve.html'>Retour</a>";
          }

          mysqli_close($connect);


          ?>

  </body>
</html>