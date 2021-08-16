<?php require_once("site_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
// Coleta os dados
$sql_noticia = "SELECT codigo_noticia, titulo, arquivo, resumo, data, status FROM noticia WHERE status = 'L' ORDER BY data DESC";
$query_noticia = $pdo->query($sql_noticia);
$noticias = $query_noticia->fetchAll( PDO::FETCH_ASSOC );
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
<section class="page-title overlay" style="background-image: url('http://demo.themefisher.com/themefisher/biztrox-hugo/images/background/page-title.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="text-white font-weight-bold">Publicações</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>Blog</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- /page title -->


<!-- blog -->
<section class="section">
    <div class="container">
        <div class="row">
            
            <?php foreach($noticias AS $noticia):?>
            <!-- blog-item -->
            <div class="col-lg-4 col-sm-6 mb-4">
                <article class="card">
                    <a href="noticia.php?id=<?php echo codifica($noticia["codigo_noticia"]);?>">
                    <div class="card-img-wrapper overlay-rounded-top">
                        <img class="card-img-top" src="conteudos/noticia/<?php echo $noticia["arquivo"];?>" alt="blog-thumbnail">
                    </div>
                    </a>
                    <div class="card-body p-0">
                        <div class="d-flex">
                            <div class="py-3 px-4 border-right text-center">
                                <h3 class="text-primary mb-0"><?php echo date('d', strtotime($noticia["data"]));?></h3>
                                <p class="mb-0"><?php echo mes_extenso_abreviado(date('m', strtotime($noticia["data"])));?></p>
                            </div>
                            <div class="p-3">
                                <a href="noticia.php?id=<?php echo codifica($noticia["codigo_noticia"]);?>" class="h4 font-primary text-dark"><?php echo $noticia["titulo"];?></a>
                                <p><?php echo $noticia["resumo"];?></p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <?php endforeach;?>   
            
        </div>
    </div>
</section>
<!-- /blog -->


<!-- footer -->
<footer class="bg-secondary">
    <?php include "site_mod_rodape.php";?>
</footer>
<!-- /footer -->

<?php include "site_mod_include_js.php";?>

</body>

</html>