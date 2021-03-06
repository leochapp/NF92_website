<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class='all_pages'>
  <h1 class="title">Ajouter un élève</h1>

        <?php
        include('connexion.php');

          $prenom =$_POST["fname"];
          $nom=$_POST["lname"];
          $bdate=$_POST["bdate"];
          $genre=$_POST["genre"];
          //récupération des données qui proviennent du formulaire html

          // prévention contre l'injection sql
          $nom = trim(mysqli_real_escape_string($connect, $nom));
          $bdate = mysqli_real_escape_string($connect, $bdate);
          $genre = mysqli_real_escape_string($connect, $genre);
          $prenom = trim(mysqli_real_escape_string($connect, $prenom));

          //prévention contre l'exécution de script chez d'autres utilisateurs - pas de scripts en BDD
          $nom = htmlspecialchars($nom);
          $bdate = htmlspecialchars($bdate);
          $genre = htmlspecialchars($genre);
          $prenom = htmlspecialchars($prenom);


          $subject = $prenom;
          // <>\/+"*%&()=?`^'[]!${}_:;,
          $pattern = '/[][(){}<>\/+"*%&=?`^\!$_:;,-]/';


          date_default_timezone_set('Europe/Paris');
          $date = date("Y-m-d");

          //vérification que les champs soient non vides, c'est une seconde vérification en plus du required dans la balise html
          if (empty($nom) or empty($prenom)) {
            echo "<div class='retour'>";
            echo "<p> Attention : Veuillez saisir votre nom ainsi que votre votre prénom.</p><br>";
            echo "<a class='space' href='bienvenue.html'><input class='buttonclick' type='button' value='Accueil'/></a>";
            echo "<a class='sapce' href='ajout_eleve.html'><input class='buttonclick'type='button' value='Retour'/></a></div>";
          }
          else{
            //vérification du nom dans la BDD pour voir si il n'y est pas déjà
            $query = "SELECT * FROM eleves WHERE nom ='$nom' and prenom='$prenom'";
            $result = mysqli_query($connect, $query);
            if (!$result){
              echo "<br>erreur".mysqli_error($connect);
              exit;
              }
            $response=mysqli_fetch_array($result);

            if($response){
              if ($response['nom'] == $nom and $response['prenom'] == $prenom ){
                // si il y a déjà un nom présent on génère un form html pour valider l'ajout
                echo "<fieldset>";
                echo "<legend><p>Valider élève</p></legend>";
                echo "<p> Le nom de cet élève est déjà présent dans la base de données</p>";
                echo "<form method='POST' action='valider_eleve.php'>";
                echo "<input type='hidden' name='nom' value ='".$nom."'>";
                echo "<input type='hidden' name='prenom' value ='".$prenom."'>";
                echo "<input type='hidden' name='bdate' value ='".$bdate."'>";
                echo "<input type='hidden' name='genre' value ='".$genre."'>";
                echo "<label for='valider1'> Valider l'ajout</label>";
                echo "<input type='radio' name='valider' id='valider1' selected value='1'><br><br>";
                echo "<label for='valider2'> Annuler l'ajout</label>";
                echo "<input type='radio' name='valider' id='valider2' value='2'><br><br>";
                echo "<input id='survol' class='formbutton'type='submit' value='Valider'>";
                echo "<input id='survol' class='formbutton' type='reset'>";
                echo "</fieldset>";
              }
              else{
                //si l'utilisateur a bien rempli son nom et son prénom alors on envoie les informations vers la BDD
                $query = "INSERT INTO eleves VALUES(NULL,"."'$nom'".","."'$prenom'".","."'$bdate'".","."'$date'".","."'$genre'".")";
                $result = mysqli_query($connect, $query);
                // code de debugage
                if (!$result){
                  echo "<br>erreur".mysqli_error($connect);
                  exit;
                  }

                echo "<div class='retour'>";
                echo "<p>Votre inscription a bien été prise en compte</p>";
                echo "<a class='space' href='bienvenue.html'><input type='button' class='buttonclick' value='Accueil' /></a>";
                echo "<a class='space' href='ajout_eleve.html'><input class='buttonclick'type='button' value='Ajout élève.'/></a></div>";
            }
            }
            else{
              //si l'utilisateur a bien rempli son nom et son prénom alors on envoie les informations vers la BDD
              $query = "INSERT INTO eleves VALUES (NULL,"."'$nom'".","."'$prenom'".","."'$bdate'".","."'$date'".","."'$genre'".")";
              $result = mysqli_query($connect, $query);
              if (!$result){
                echo "<br>erreur".mysqli_error($connect);
                exit;
                }
              // $query utilise comme parametre de mysqli_query
              // le test ci-dessous est desormais impose pour chaque appel de :
              // mysqli_query($connect, $query)
              echo "<div class='retour'>";
              echo "<p>Votre inscription a bien été prise en compte</p>";
              echo "<a class='space' href='bienvenue.html'><input class='buttonclick'type='button' value='Accueil'/></a>";
              echo "<a class='space' href='ajout_eleve.html'><input class='buttonclick'type='button' value='Ajout élève'/></a></div>";
          }
          }

          mysqli_close($connect);


          ?>

          <footer>
            <p class="copyright"><?php  include('footer.php'); ?></p>
          </footer>

  </body>
</html>
