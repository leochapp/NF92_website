<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class='all_pages'>
  <h1>Calendrier élève</h1>

<?php

include('connexion.php');
// récupération de la date du jour mise dans $date
date_default_timezone_set('europe/paris');
$date = date("Y-m-d");


if(empty($_POST['ideleve'])){
  echo"<p>Veuillez à bien selectionner un élève </p>";
  echo"<a href='visualisation_calendrier_eleve.php'>Retour</a>";
  echo"<a href='bienvenue.html'>Accueil</a>";
}
else{

  $ideleve = $_POST['ideleve'];

  $request = mysqli_query($connect,"SELECT * FROM inscription
  INNER JOIN seances
  ON inscription.idseance = seances.idseance
  INNER JOIN theme
  ON theme.idtheme = seances.idtheme
  WHERE DateSeance > $date
  WHERE inscription.ideleve = $ideleve;");
  if (!$request){
    echo "<br>erreur".mysqli_error($connect);
    exit;
    }

  $i = 0
  $requestcount = mysqli_num_rows($request);

  $nomtheme = array(
      while($i<$requestcount){
        'nom'.$i => mysqli_fetch_array($request)
        $i++;
        }
  )


  if($requestcount == 0){
    $request2 = mysqli_query($connect, "SELECT * FROM seances
      INNER JOIN theme
      WHERE seances.idtheme = theme.idtheme
      AND DateSeance > $date";)
      if (!$request2){
        echo "<br>erreur".mysqli_error($connect);
        exit;
        }

      $request2count = mysqli_num_rows($request2);

      if($request2count == 0 ){
        echo "<p> Pas de séances à venir dans le calendrer </p>";
        exit;


      while(mysqli_fetch_array($request2)){
        echo"<p>".$request2['DateSeance']." / ".$request2['nom'];
      }
  }
  else{







    $request2 = mysqli_query($connect, "SELECT * FROM seances
      INNER JOIN theme
      ON seances.idtheme = theme.idtheme
      INNER JOIN inscription
      ON seances.idseance = inscrption.idseance
      WHERE DateSeance > $date
      AND theme.nom != ";);

      $request2count = mysqli_num_rows($request2);

      if($request2count == 0 ){
        echo "<p> Pas de séances à venir dans le calendrer </p>";
        exit;
      }


  }



}




mysqli_close($connect);



?>
<footer>
  <p class="copyright"><?php  include('footer.php'); ?></p>
</footer>

</body>
</html>
