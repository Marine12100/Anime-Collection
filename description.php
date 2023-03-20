<?php
//RECUPERATION DU TOKEN D'API
    $filename = "secrets";

    if (@file_exists($filename)) {
        $fichier = @fopen($filename, "r");
        
        if ($fichier != 0) {
            $apiKey = fread($fichier, 50);
            fclose($fichier);
        } else {
            die("Erreur : ouverture impossible du fichier $filename !<br />");
        }
    } else {
        die("Erreur : le fichier $filename n’existe pas !<br />");
    }

//DESCRIPTION

    $id = $_GET["id"];
    $url = "http://localhost:8080/AnimeAPI/animes/" . $id;

    $ch = curl_init();
      
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("api-key: " . $apiKey));

    $response = curl_exec($ch);
    $err = curl_error($ch);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $resultDescription = json_decode($response, true);
    }

    curl_close($ch);

//GENRE

    $genre = $resultDescription["genre"];
    $urlGenre = "http://localhost:8080/AnimeAPI/animes/" . $id . "/" . $genre;

    $chGenre = curl_init();
      
    curl_setopt($chGenre, CURLOPT_URL, $urlGenre);
    curl_setopt($chGenre, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chGenre, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($chGenre, CURLOPT_HTTPHEADER, array("api-key: " . $apiKey));

    $responseGenre = curl_exec($chGenre);
    $errGenre = curl_error($chGenre);
    
    if ($errGenre) {
      echo "cURL Error #:" . $errGenre;
    } else {
      $resultGenre = json_decode($responseGenre, true);
    }

    curl_close($chGenre);
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>L'attaque des Titans - Animé Collection</title>
        <!-- Favicon-->
        <link rel="icon" href="files/Anime Collection.png" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
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
                  <a class="navbar-brand text-white" href="index.php">
                    <img src="files/Anime Collection EXTENDED.png"
                            alt="Logo"
                            width="200"
                            height="30"
                            class="d-inline-block align-text-center">
                  </a>
                </div>
              </nav>
        </header>

        <!-- Description de l'anime-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">
                        <video class="card-img-top mb-5 mb-md-0"
                            src="<?php echo $resultDescription["lien_video"];?>"
                            controls poster="<?php echo $resultDescription["lien_image"];?>">
                        </video>
                    </div>
                    <div class="col-md-6">
                        <h1 class="display-5 fw-bolder"><?php echo $resultDescription["titre"];?></h1>
                        <div class="fs-5 mb-5">
                            <span><?php echo $resultDescription["studio_animation"];?></span>
                        </div>
                        <p class="lead">
                        <?php echo $resultDescription["synopsis"];?>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Liste d'anime du même style -->
        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Animés du même genre</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                        foreach ($resultGenre as $result){
                            ?>
                                <!--Carte-->
                                <div class="col mb-5">
                                    <a href="description.php?id=<?php echo $result["id"];?>"
                                        style="text-decoration: none;">
                                        <div class="card">
                                            <img class="card-img-top"
                                                    src="<?php echo $result["lien_image"];?>"
                                                    alt="aperçu de l'animé"/>
                                            <h3 class="fw-bolder"><?php echo $result["titre"];?></h3>
                                            <div class="card-body p-4 focus-content">
                                                <p><?php echo $result["studio_animation"];?><br/>
                                                    <small class="text-muted">
                                                        <?php echo $result["date_sortie"];?>
                                                    </small>
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
        </section>
        <!-- Footer-->
        <footer class="py-5" style="background-color: #2F6288;">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Animé Collection</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
