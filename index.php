<?php
//RECUPERATION DU TOKEN D'API
  $filename = "secrets";

  if (@file_exists($filename)) {
      $fichier = @fopen($filename, "r");

      if($fichier != FALSE) {
          $apiKey = fread($fichier, 50);
          fclose($fichier);
      }
      else die("Erreur : ouverture impossible du fichier $filename !<br />");
  }
  else die("Erreur : le fichier $filename n’existe pas !<br />");

//LISTE ANIMES

  $url = "http://localhost:8080/AnimeAPI/animes";

  $ch = curl_init();
    
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("api-key: ". $apiKey));

  $response = curl_exec($ch);
  $err = curl_error($ch);
  
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    $result = json_decode($response, true);
  }

  curl_close($ch);
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon-->
    <link rel="icon" href="files/Anime Collection.png" />

    <title>Accueil - Animé Collection</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/album.css" rel="stylesheet">
  </head>

  <body>

    <!-- En-tête / Barre de navigation -->
    <header>
      <nav class="navbar bg-body-tertiary" style="background-color: #2F6288;">
          <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">
              <img src="files/Anime Collection EXTENDED.png" alt="Logo" width="200" height="30" class="d-inline-block align-text-center">
            </a>
          </div>
        </nav>
    </header>

    <main role="main">

      <!-- Barre de présentation -->
      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Anime Collection</h1>
          <p class="lead text-muted">
            Bienvenue sur le site web Animé Collection,</br>
            LE site qui répertorie touts les animés ancien ou récent !</p>
        </div>
      </section>

      <!-- Liste de cartes -->
      <div class="album py-5 bg-light">
        <div class="container">

          <!-- Ligne -->
          <div class="row">

          <?php
          foreach($result as $id){
            ?>
            <!--Carte-->
            <div class="col mb-5">
                <a href="description.php?id=<?php echo $id["id"];?>" style="text-decoration: none;">
                    <div class="card">
                        <img class="card-img-top" src="<?php echo $id["lien_image"];?>"/>
                        <h3 class="fw-bolder"><?php echo $id["titre"];?></h3>
                        <div class="card-body p-4 focus-content">
                            <p><?php echo $id["studio_animation"];?><br/>
                                <small class="text-muted"><?php echo $id["date_sortie"];?></small>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <?php
          }
          ?>
          </div>
        </div>
      </div>

    </main>

    <!-- Pied de page -->
    <footer class="py-5" style="background-color: #2F6288;">
      <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Animé Collection</p></div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./Album example for Bootstrap_files/jquery-3.2.1.slim.min.js.téléchargement" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="./Album example for Bootstrap_files/popper.min.js.téléchargement"></script>
    <script src="./Album example for Bootstrap_files/bootstrap.min.js.téléchargement"></script>
    <script src="./Album example for Bootstrap_files/holder.min.js.téléchargement"></script>
  

<svg xmlns="http://www.w3.org/2000/svg" width="348" height="225" viewBox="0 0 348 225" preserveAspectRatio="none" style="display: none; visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs><style type="text/css"></style></defs><text x="0" y="17" style="font-weight:bold;font-size:17pt;font-family:Arial, Helvetica, Open Sans, sans-serif">Thumbnail</text></svg></body></html>