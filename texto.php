<?php require_once("site_mod_include.php");?>
<?php
$codigo_texto = protege($_GET["id"]);
//Abre a conexão
$pdo = Database::conexao();

// Coleta os dados
$sql_texto = "SELECT codigo_texto, titulo, arquivo, subtitulo, texto, status FROM texto WHERE codigo_texto = '".$codigo_texto."'";
$query_texto = $pdo->query($sql_texto);
$texto = $query_texto->fetch( PDO::FETCH_ASSOC );

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "site_mod_head.php";?>
</head>

<body>


    <!-- preloader start -->
    <div class="preloader">
        <img src="images/preloader.gif " alt="preloader">
    </div>
    <!-- preloader end -->

<!-- navigation -->
<header>
    <!-- top header -->
    <div class="top-header">
        <?php include "site_mod_top.php";?>
    </div>
    <!-- nav bar -->
    <div class="navigation">
        <?php include "site_mod_menu.php";?>
    </div>
</header>
<!-- Search Form -->
<div class="search-form">
    <?php include "site_mod_busca.php";?>
</div>
<!-- /navigation -->

<!-- page title -->
<section class="page-title overlay" style="background-image: url('images/background/bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="text-white font-weight-bold"><?php echo $texto["titulo"];?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li><?php echo $texto["titulo"];?></li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- /page title -->


<!-- philosophy -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 order-2 order-lg-1">
                <h5 class="section-title-sm"><?php echo $texto["titulo"];?></h5> 
                <h4 class="section-title section-title-border-half"><?php echo $texto["subtitulo"];?></h4> 
                <p><?php echo $texto["texto"];?></p> 
            </div>
            <!-- philosophy image -->
            <div class="col-lg-5 align-self-center order-1 order-lg-2 mb-md-50">
                <img class="img-fluid w-100" src="conteudos/texto/<?php echo $texto["arquivo"];?>" alt="<?php echo $texto["titulo"];?>">
            </div>
        </div>
    </div>
</section>
<!-- /philosophy -->


<!-- footer -->
<footer class="bg-secondary">
    <?php include "site_mod_rodape.php";?>
</footer>
<!-- /footer -->

<?php include "site_mod_include_js.php";?>

</body>

</html>