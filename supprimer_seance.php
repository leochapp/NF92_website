<html>
    <body>

        <?php
          $theme_name_supp = $_POST["theme_name_supp"];

          $dbhost = 'localhost:3307';
          $dbuser = 'root';
          $dbpass = '';
          $dbname = 'nf92p018';
          //Connexion à la BDD
          $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
          //la ligne suivante permet d'éviter les problèmes d'accent entre la page web et le serveur mysql
          mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8

          if isset($_POST['menuchoixseance_supp']){
            echo "<p> Veuillez à bien selectionner une séance pour la supprimer </p>";
            echo "<a href='supprimer_seance.php'>Retour</a>";
          }
          else{
            $numseance=$_POST['menuchoixseance_supp'];
            //sinon on envoie une requete pour modifier le 0 en 1 pour montrer que changer l'état de supprime
            $query = "UPDATE seance SET supprime='1' WHERE idseance='$numseance';";
            // La ligne du dessus change la valeur du booléen supprime de 0 à 1 pour signifier que le thème est supprimé
            $result = mysqli_query($connect, $query);
            echo "<p> La séance a bien était supprimée</p>";
            echo "<a href='suppression_seance.php' target='contenu'> Retour <a>";
          }

          mysqli_close($connect);


          ?>

  </body>
</html>