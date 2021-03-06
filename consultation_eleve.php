<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class='all_pages'>
  <h1 class="title">Consulter les informations d'un élève</h1>

        <?php

      include('connexion.php');

      // Selection d'un élève
        $result = mysqli_query($connect,"SELECT * FROM eleves");
        if (!$result){
          echo "<br>retour".mysqli_error($connect);
          exit;
          }
        $responseCount=mysqli_num_rows($result);

        // Vérification qu'on ait bien au moins un élève
        if($responseCount == 0 ){
          echo "<div class='retour'>";
          echo"<p>Attention : Il faut avoir au moins un élève inscrit pour pouvoir consulter ses informations </p> ";
          echo "<a class='space' href='bienvenue.html'><input class='buttonclick' type='button' value='Accueil' /></a>";
          echo "<a class='space' href='aout_eleve.html'><input class='buttonclick'type='button' value='Ajout élève'/></a></div>";

        }

        // si on a des élèves dans la BDD, on les affiche dans un formulaire HTML
        
        else{
          echo "<form method='POST' action='consulter_eleve.php'>";
          echo "<fieldset >";
          echo "<legend><p>Selectionner un élève</p></legend>";
          echo "<label for='ideleve'> Veuillez selectionner un élève  </label><br><br>";
          echo "<select name='ideleve' id='ideleve'size='4' style='width:auto; text-align: center'>";
          /*Tant qu'on a des choses qui rentrent dans notre tableau alors on va afficher les noms qu'on récupère dans une balise <select> en html*/
          while($response  = mysqli_fetch_array($result)){

            echo "<option value=".$response['ideleve'].">".$response['nom'].' '.$response['prenom']."</option><br><br>";

          }
          echo "</select><br><br>";
          echo "<br><br>";
          echo "<input class='formbutton' type='submit' value='Choisir'>";
          echo "</fieldset>";
          echo "</form>";
        }

          mysqli_close($connect);


          ?>
          <footer>
            <p class="copyright"><?php  include('footer.php'); ?></p>
          </footer>

  </body>
</html>
