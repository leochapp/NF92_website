<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class='all_pages'>

        <?php

        include('connexion.php');
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d");




        if(empty($_POST['menuchoixseance']) or empty($_POST['menuchoixeleve'])){
          echo "<div class='retour'>";
          echo"<p>Attention : Veuillez à bien selectionner une séance ainsi qu'un élève.</p>";
          echo "<a class='space' href='bienvenue.html'><input class='buttonclick' type='button' value='Accueil' /></a>";
          echo "<a class='space' href='desinscription_seance_selection.php'><input class='buttonclick'type='button' value='Retour'/></a></div>";
        }
        else{
          $ideleve = $_POST['menuchoixeleve'];
          $ideleve = mysqli_real_escape_string($connect, $ideleve);
          $idseance = $_POST['menuchoixseance'];
          $idseance = mysqli_real_escape_string($connect, $idseance);


          $verification_inscription = mysqli_query($connect,"SELECT * FROM inscription
            INNER JOIN seances
            ON inscription.idseance = seances.idseance
            INNER JOIN theme
            ON seances.idtheme = theme.idtheme
            WHERE DateSeance > $date
            AND ideleve = $ideleve
            AND seances.idseance = $idseance");
            if (!$verification_inscription){
              echo "<br>erreur".mysqli_error($connect);
              exit;
              }
          $nombreinscription = mysqli_num_rows($verification_inscription);

          if($nombreinscription == 0){
            echo "<div class='retour'>";
            echo "<p>Attention : L'élève n'est pas inscrit à cette séance.</p>";
            echo "<a class='space' href='bienvenue.html'><input class='buttonclick' type='button' value='Accueil' /></a>";
            echo "<a class='space' href='desinscription_seance.php'><input class='buttonclick'type='button' value='Retour'/></a></div>";
            exit;
          }
          else{
          $request = mysqli_query($connect,"DELETE FROM inscription WHERE ideleve = $ideleve AND idseance = $idseance ");
          if (!$request){
            echo "<br>erreur".mysqli_error($connect);
            exit;
            }
          echo "<div class='retour'>";
          echo "<p>L'élève a bien été désincrit.</p><br>";
          echo "<a class='space' href='bienvenue.html'><input class='buttonclick' type='button' value='Accueil' /></a>";
          echo "<a class='space' href='desinscription_seance.php'><input class='buttonclick'type='button' value='Desinscriptions'/></a></div>";
          }
        }




          mysqli_close($connect);


          ?>
          <footer>
            <p class="copyright"><?php  include('footer.php'); ?></p>
          </footer>

  </body>
</html>
