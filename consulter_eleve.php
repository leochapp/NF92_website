<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class='all_pages'>
  <h1 class="title">Consultation élève</h1>

        <?php

        include('connexion.php');
        date_default_timezone_set('europe/paris');
        $date = date("Ymd");


        if(empty($_POST['ideleve']) ){
          echo"<p>Veuillez à bien sélectionner un élève </p><br> ";
          echo "<a href='consultation_eleve.php'><input class='buttonclick'type='button' value='Retour'/></a>";
          echo "<a href='bienvenue.html'><input class='buttonclick' type='button' value='Accueil' /></a>";
        }
        else{

          $ideleve = $_POST['ideleve'];
          $ideleve = mysqli_real_escape_string($connect, $ideleve);

          $request = mysqli_query($connect, "SELECT * FROM eleves WHERE ideleve=$ideleve");
          if (!$request){
            echo "<br>erreur".mysqli_error($connect);
            exit;
            }
          $infos = mysqli_fetch_array($request);
          if($infos['genre']==1){
              echo "<p> Mme. ".$infos['nom'].' '.$infos['prenom']." née le ".$infos['dateNaiss']." inscrite le ".$infos['dateInscription']."</p>";
          }
          else{
              echo "<p> M. ".$infos['nom'].' '.$infos['prenom']." né le ".$infos['dateNaiss']." inscrit le ".$infos['dateInscription']."</p>";
          }
          $request_seance = mysqli_query($connect, "SELECT * FROM inscription
            INNER JOIN seances
            ON inscription.idseance = seances.idseance
            INNER JOIN theme
            ON theme.idtheme = seances.idtheme
            WHERE inscription.ideleve = $ideleve
            AND DateSeance < $date");
            if (!$request_seance){
              echo "<br>erreur".mysqli_error($connect);
              exit;
              }
          if(mysqli_num_rows($request_seance) == 0){
            echo "<p>".$infos['nom'].' '.$infos['prenom']." n'a effectué aucune séance dans le passé</p>";
          }
          else{
            while($response =mysqli_fetch_array($request_seance)){
              echo "<p>".$infos['nom'].' '.$infos['prenom']." a assité à ".$response['nom']." le ".$response['DateSeance'];
              if($response['note'] != -1){
              echo" et a obtenu la note de ".$response['note']."/40</p>";
              }
              else{
                echo" et n'a pas été évalué sur cette séance</p>";
              }
            }
          }
          echo "<a href='consultation_eleve.php'><input class='buttonclick'type='button' value='Nouvelle consultation'/></a><br>";
          echo "<a href='bienvenue.html'><input class='buttonclick' type='button' value='Accueil' /></a>";

        }


          mysqli_close($connect);


          ?>
          <footer>
            <p class="copyright"><?php  include('footer.php'); ?></p>
          </footer>

  </body>
</html>
