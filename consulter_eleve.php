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
        $date = date("Y-m-d");

        //vérification des champs envoyés par le formulaire
        if(empty($_POST['ideleve']) ){
          echo "<div class='retour'>";
          echo"<p>Attention : Veuillez à bien sélectionner un élève.</p><br> ";
          echo "<a class='space' href='bienvenue.html'><input class='buttonclick' type='button' value='Accueil' /></a>";
          echo "<a class='space' href='consultation_eleve.php'><input class='buttonclick'type='button' value='Retour'/></a></div>";
          exit;
        }

        else{

          //Affichage de toutes les informations sur un élève qu'on a en base de donnée

          echo "<div class='retour' style='width:auto;height:auto;'>";
          $ideleve = $_POST['ideleve'];

          $ideleve = mysqli_real_escape_string($connect, $ideleve);

          //récupération de toutes les infos personelles de l'élève
          $request = mysqli_query($connect, "SELECT * FROM eleves WHERE ideleve=$ideleve");

          if (!$request){
            echo "<br>erreur".mysqli_error($connect);
            exit;
            }

          $infos = mysqli_fetch_array($request);
          if($infos['genre']==1){
              echo "<p style='text-decoration: underline;'> Mme. ".$infos['nom'].' '.$infos['prenom']." née le ".$infos['dateNaiss']." inscrite le ".$infos['dateInscription']."</p><br>";
          }
          else{
              echo "<p style='text-decoration: underline;'> M. ".$infos['nom'].' '.$infos['prenom']." né le ".$infos['dateNaiss']." inscrit le ".$infos['dateInscription']."</p><br>";
          }

          //requête pour connaitre les séances auxquelles est inscrit l'élève dans le passé !

          $request_seance = mysqli_query($connect, "SELECT * FROM inscription
            INNER JOIN seances
            ON inscription.idseance = seances.idseance
            INNER JOIN theme
            ON theme.idtheme = seances.idtheme
            WHERE inscription.ideleve = $ideleve
            AND DateSeance < '$date'");

          if (!$request_seance){
              echo "<br>erreur".mysqli_error($connect);
              exit;
              }

          // s'il n'est inscrit à aucune séance on affiche un message le signifiant

          if(mysqli_num_rows($request_seance) == 0){
            echo "<p> Aucune séance suivie dans le passé</p>";
          }
          else{
            if(mysqli_num_rows($request_seance) == 1){
              echo "<p>Séance suivie par l'élève :</p>";
            }
            // sinon on affiche toutes les séances auxquelles il est inscrit
            else{
              echo "<p>Séances suivies par l'élève :</p>";
            }

            while($response =mysqli_fetch_array($request_seance)){
              echo "<p style='font-size:medium'>  ".$response['nom']." le ".$response['DateSeance'].' .';
              if($response['note'] != -1){
              echo" et a obtenu la note de ".$response['note']."/40</p>";
              }
              else{
                echo" et n'a pas été évalué sur cette séance</p>";
              }
            }
          }

          echo "<br>";

          //requête pour connaitre les séances auxquelles est inscrit l'élève dans le futur !

          $request_seance2 = mysqli_query($connect, "SELECT * FROM inscription
            INNER JOIN seances
            ON inscription.idseance = seances.idseance
            INNER JOIN theme
            ON theme.idtheme = seances.idtheme
            WHERE inscription.ideleve = $ideleve
            AND DateSeance > '$date'");
            if (!$request_seance2){
              echo "<br>erreur".mysqli_error($connect);
              exit;
              }
          if(mysqli_num_rows($request_seance2) == 0){
            echo "<p> Aucune séance n'est prévue pour cet élève .</p>";
          }
          else{
            if(mysqli_num_rows($request_seance2) == 1){
              echo "<p>Séance plannifiée pour l'élève :</p>";
            }
            else{
              echo "<p>Séances plannifiées pour l'élève :</p>";
            }
            while($response =mysqli_fetch_array($request_seance2)){
              echo "<p style='font-size:medium'>    ".$response['nom']." le ".$response['DateSeance'].' .</p>';
            }
          }





          echo "<a class='space' href='bienvenue.html'><input class='buttonclick'  type='button' value='Accueil' /></a>";
          echo "<a class='space' href='consultation_eleve.php'><input class='buttonclick' type='button' value='Consultation'/></a><br>";
          echo "</div>";



        }



          mysqli_close($connect);


          ?>
          <footer>
            <p class="copyright"><?php  include('footer.php'); ?></p>
          </footer>

  </body>
</html>
