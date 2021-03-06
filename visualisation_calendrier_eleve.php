<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class='all_pages'>
  <h1 class="title">Calendrier </h1>

        <?php

        include('connexion.php');
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d");


        //selection de élèves présetns en BDD
        $result = mysqli_query($connect,"SELECT * FROM eleves");

        if (!$result){
          echo "<br>erreur".mysqli_error($connect);
          exit;
          }

        $responseCount1=mysqli_num_rows($result);

        // s'il n'y a pas d"élève dans ma BDD alors on affiche un message d'erreur
        if($responseCount1 == 0){
          echo "<div class='retour'>";
          echo"<p>Attention : Il faut avoir au moins un élève ajouté pour visualiser son calendrier.</p><br>";
          echo "<a class='space' href='bienvenue.html'><input class='buttonclick' type='button' value='Accueil' /></a>";
          echo "<a class='space' href='inscription_eleve.php'><input class='buttonclick' type='button' value='retour'/></a></div>";
        }

        else{
          //sinon on permet à l'utilisateur de selectionner un des élèves pour voir son calendrier
          echo "<fieldset>";
          echo "<legend><p>Selection élève</p></legend>";
          echo "<form method='POST' action='visualiser_calendrier_eleve.php'>";
          echo "<label for='menuchoixeleve'> Veuillez selectionner un élève pour voir le calendrier </label><br>";
          echo "<select name='menuchoixeleve' id='menuchoixeleve' multiple size='4' style='width:auto; text-align: center'>";
          /*Tant qu'on a des choses qui rentrent dans notre tableau alors on va afficher les noms qu'on récupère dans une balise <select> en html*/

          //affichage des noms présents en BDD
          while($response  = mysqli_fetch_array($result)){

            echo "<option value=".$response['ideleve'].">".$response['nom'].' '.$response['prenom']."</option><br><br>";

          }
          echo "</select><br><br>";
          echo "<br><br>";
          echo "<input class='formbutton' type='submit' value='Valider'>";
          echo "</form>";
          echo "</fieldset>";
        }

          mysqli_close($connect);


          ?>
        <footer>
            <p class="copyright"><?php // include('footer.php'); ?></p>
          </footer>

  </body>
</html>
