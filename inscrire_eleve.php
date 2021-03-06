<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class='all_pages'>
  <h1 class="title">Inscrire un élève </h1>

        <?php

        include('connexion.php');
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d");


        //vérification des champs

        if(empty($_POST['menuchoixseance']) or empty($_POST['menuchoixeleve'])){
          echo "<div class='retour'>";
          echo"<p>Attention : Veuillez à bien selectionner une séance ainsi qu'un élève .</p>";
          echo "<a class='space' href='bienvenue.html'><input class='buttonclick' type='button' value='Accueil' /></a>";
          echo "<a class='space' href='inscription_eleve.php'><input class='buttonclick'type='button' value='Insciptions'/></a></div>";
        }
        else{

          // récupération des données + vérification injection SQL + éxécution de scripts

          $idseance = $_POST['menuchoixseance'];
          $idseance = mysqli_real_escape_string($connect, $idseance);
          $idseance = htmlspecialchars($idseance);

          $ideleve = $_POST['menuchoixeleve'];
          $ideleve = mysqli_real_escape_string($connect, $ideleve);
          $ideleve = htmlspecialchars($ideleve);


          //requête pour vérifier si l'élève n'est pas déjà inscrit

          $verification_inscription = mysqli_query($connect,"SELECT * FROM inscription WHERE ideleve= $ideleve  AND idseance = $idseance ");

          if (!$verification_inscription){
            echo "<br>erreur".mysqli_error($connect);
            exit;
            }

          $nb_erreur = mysqli_num_rows($verification_inscription);

          // si la requête obtient un élément alors l'élève est déjà inscrit + affichage message erreur

          if($nb_erreur != 0){
            echo "<div class='retour'>";
            echo "<p>L'élève est déjà inscrit à cette séance, vous ne pouvez pas l'ajouter deux fois à une même séance</p>";
            echo "<a class='space' href='bienvenue.html'><input class='buttonclick' type='button' value='Accueil' /></a>";
            echo "<a class='space' href='inscription_eleve.php'><input class='buttonclick'type='button' value='Insciptions'/></a></div>";
          }
          else{
            //sinon on inscrit bien l'élève et on fixe comme valeur de la note à -1
            $request = mysqli_query($connect,"INSERT INTO inscription VALUES("."'$idseance'".","."'$ideleve'".","."'-1'".") ");

            if (!$request){
              echo "<br>erreur".mysqli_error($connect);
              exit;
              }

            //on doit actualiser le nombre d'inscrit dans une autre table (seances)

            $incrementation_nbinscrits = mysqli_query($connect,"UPDATE seances Set nb_inscrits=nb_inscrits+1 where idseance=$idseance ");

            if (!$incrementation_nbinscrits){
              echo "<br>erreur".mysqli_error($connect);
              exit;
              }
              
            echo "<div class='retour'>";
            echo "<p>L'inscription a bien été prise en compte</p>";
            echo "<a class='space' href='bienvenue.html'><input class='buttonclick' type='button' value='Accueil' /></a>";
            echo "<a class='space' href='inscription_eleve.php'><input class='buttonclick'type='button' value='Insciptions'/></a></div>";
          }

        }



          mysqli_close($connect);


          ?>
          <footer>
            <p class="copyright"><?php  include('footer.php'); ?></p>
          </footer>

  </body>
</html>
