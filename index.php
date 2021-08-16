<?php require_once("site_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
// Coleta os dados
$sql_noticia = "SELECT codigo_noticia, titulo, arquivo, resumo, data, status FROM noticia WHERE status = 'L' ORDER BY data DESC LIMIT 3";
$query_noticia = $pdo->query($sql_noticia);
$noticias = $query_noticia->fetchAll( PDO::FETCH_ASSOC );

// Coleta os membros da equipe
$sql_equipe = "SELECT codigo_texto, titulo, arquivo, banner, subtitulo, texto, sessao, status FROM texto WHERE sessao = 2 AND status = 'L' ORDER BY RAND()";
$query_equipe = $pdo->query($sql_equipe);
$programacao_semanal = $query_equipe->fetchAll( PDO::FETCH_ASSOC );

// Coleta texto institucional
$sql_texto_institucional = "SELECT codigo_texto, titulo, arquivo, banner, subtitulo, texto, sessao, status FROM texto WHERE codigo_texto = 1";
$query_texto_institucional = $pdo->query($sql_texto_institucional);
$texto_institucional = $query_texto_institucional->fetch( PDO::FETCH_ASSOC );

//consulta banners
$sql_consulta_banner_principal = "SELECT banner.codigo_banner, banner.titulo_banner, banner.descricao_banner, banner.data_inicial, banner.data_final, banner.arquivo, banner.status, tipo_banner.descricao_tipo_banner, tipo_banner.tamanho_tipo_banner FROM banner 
JOIN tipo_banner ON banner.codigo_tipo_banner = tipo_banner.codigo_tipo_banner
WHERE banner.status = 'L' AND banner.codigo_tipo_banner = 1 ORDER BY RAND() LIMIT 4";
$result = $pdo->query( $sql_consulta_banner_principal );
$banner_principal = $result->fetchAll( PDO::FETCH_ASSOC );
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


<!-- hero slider -->
<section>
    <?php include "site_mod_slider.php";?>
</section>
<!-- /hero slider -->



<!-- service -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <h5 class="section-title-sm">Conheça nossa</h5>
                <h2 class="section-title section-title-border">Programação Semanal</h2>
            </div>
            
            <?php foreach($programacao_semanal as $programacao):?>
            <!-- service item -->
            <div class="col-lg-4 col-sm-6 mb-5">
                <div class="card text-center">
                    <h4 class="card-title pt-3"><?php echo $programacao["titulo"];?></h4>
                    <div class="card-img-wrapper">
                        <img class="card-img-top rounded-0" src="conteudos/texto/<?php echo $programacao["arquivo"];?>" alt="service-image">
                    </div>
                    <div class="card-body p-0">
                        <i class="square-icon translateY-33 rounded ti-server"></i>
                        <p class="card-text mx-2 mb-0"><?php echo $programacao["subtitulo"];?></p>
                        <a href="texto/<?php echo url_amigavel($programacao["subtitulo"]);?>-<?php echo $programacao["codigo_texto"];?>" class="btn btn-secondary translateY-25">Leia mais</a>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
                        
        </div>
    </div>
</section>
<!-- /service -->


<!-- about -->
<section class="about section-sm overlay" style="background-image: url('images/background/about-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 ml-auto">
                <div class="rounded p-sm-5 px-3 py-5 bg-secondary">
                    <h3 class="section-title section-title-border-half text-white">Por que estudar o Espiritismo??</h3> 
                    <p class="text-white mb-40">Estudar a Doutrina Espírita propicia a iluminação interior. Em todo ministério de enobrecimento, o estudo tem regime de urgência como diretriz de segurança e veículo de libertação íntima.</p> 
                    <p class="text-white mb-40">Temas abordados durante o curso:</p> 
                    
                    <div>
                        <ul class="d-inline-block pl-0 float-sm-left mr-sm-5">
                            
                            <li class="font-secondary mb-10 text-white">
                                <i class="text-primary mr-2 ti-arrow-circle-right"></i>Deus</li>
                            
                            <li class="font-secondary mb-10 text-white">
                                <i class="text-primary mr-2 ti-arrow-circle-right"></i>Jesus</li>
                            
                            <li class="font-secondary mb-10 text-white">
                                <i class="text-primary mr-2 ti-arrow-circle-right"></i>Doutrina Espírita</li>
                            
                        </ul>
                        <ul class="d-inline-block pl-0">
                            
                            <li class="font-secondary mb-10 text-white">
                                <i class="text-primary mr-2 ti-arrow-circle-right"></i>Mediunidade</li>
                            
                            <li class="font-secondary mb-10 text-white">
                                <i class="text-primary mr-2 ti-arrow-circle-right"></i>Reforma Íntima</li>
                            
                            <li class="font-secondary mb-10 text-white">
                                <i class="text-primary mr-2 ti-arrow-circle-right"></i>Família</li>
                            
                        </ul>
                    </div>
                    
                    <a href="texto/porque-estudar-o-espiritismo-2" class="btn btn-primary mt-4"> Saiba mais </a>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /about -->


<!-- cta -->
<section class="cta overlay-primary py-50 text-center text-lg-left" style="background-image: url('images/background/cta.jpg');">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6">
                <h3 class="text-white">Faça agora mesmo sua inscrição GRÁTIS do curso:</h3> 
            </div>
            <div class="col-lg-6 text-lg-right align-self-center">
                <a href="/inscricao/escola-de-estudos-espiritas" class="btn btn-light text-uppercase"> Quero Participar</a>
            </div>
        </div>
    </div>
</section>
<!-- /cta -->


<!-- mission -->
<section class="mission section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h5 class="section-title-sm">Participe da</h5> 
                <h2 class="section-title section-title-border-half">Escola de Estudos Espíritas</h2> 
                <div class="row">
                    <div class="col-lg-12">
                         <p class="mb-40"> Você tem interesse em adentrar nas fontes do esclarecimento e consolo do Espiritismo? Os cursos de doutrina espírita oferecem luminosos ensinos deixados pelos Espíritos Superiores, que ditaram a Doutrina Espírita. É através dos cursos que poderemos ter respostas às mais frequentes perguntas para o sentindo da existência. </p> 
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <!-- accordion -->
                <div id="accordion" class="mb-md-50">
                    
                    <div class="card border-0 mb-4">
                        <div class="card-header bg-gray border p-0">
                            <a class="card-link h5 d-block tex-dark mb-0 py-10 px-4" data-toggle="collapse" href="#collapseOne">
                                <i class="ti-minus text-primary mr-2"></i> Por que estudar o Espiritismo?
                            </a>
                        </div>
                        <div id="collapseOne" class="collapse show" data-parent="#accordion">
                            <div class="card-body font-secondary text-color pl-0 pb-0">
                            Estudar a Doutrina Espírita propicia a iluminação interior. Em todo ministério de enobrecimento, o estudo tem regime de urgência como diretriz de segurança e veículo de libertação íntima.
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 mb-4">
                        <div class="card-header bg-gray border p-0">
                            <a class="card-link h5 d-block tex-dark mb-0 py-10 px-4" data-toggle="collapse" href="#collapseTwo">
                                <i class="ti-plus text-primary mr-2"></i> Quais conteúdos serão vistos no curso?
                            </a>
                        </div>
                        <div id="collapseTwo" class="collapse " data-parent="#accordion">
                            <div class="card-body font-secondary text-color pl-0 pb-0">
                                Serão estudados, desde os conteúdos básicos da Doutrina Espírita, até os cursos avançados, visando a formação de novos trabalhadores. os cursos tem duração semestral.
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 mb-4">
                        <div class="card-header bg-gray border p-0">
                            <a class="card-link h5 d-block tex-dark mb-0 py-10 px-4" data-toggle="collapse" href="#collapseThree">
                                <i class="ti-plus text-primary mr-2"></i> Quais cursos eu posso fazer?
                            </a>
                        </div>
                        <div id="collapseThree" class="collapse " data-parent="#accordion">
                            <div class="card-body font-secondary text-color pl-0 pb-0">
                                Todos que estão iniciando, comaçam pelo curso Noções Básicas de Doutrina Espírita, caso aprovado o curso seguinte é o Nosso Lar, que trará conhecimentos mais avançados à cerca do mundo espiritual. Após o curso nosso lar segue a sequência: Curso Passe, Corrente Magnética e Núcleos de Especialização.
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- chart -->
            <div class="col-lg-4">
                <img src="images/eee.png" alt="chart" class="img-fluid w-100">
            </div>
        </div>
    </div>
</section>
<!-- /mission -->



<!-- promo-video -->
<section class="promo-video overlay section" style="background-image: url(images/background/promo-video.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-white mb-20 font-weight-normal">Já conhece nossa <br/>Obra Social?</h1> 
                <div class="d-flex">
                    <a class="popup-youtube play-icon mr-4" href="https://www.youtube.com/watch?v=ZiSASNDefws">
                        <i class="ti-control-play"></i>
                    </a>
                     <p class="text-white align-self-center h4">Dê um play<br> para saber mais.</p> 
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /promo-video -->


<!-- blog -->
<section class="section bg-gray">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <h5 class="section-title-sm">Publicações</h5>
                <h2 class="section-title section-title-border-gray">Eventos, Notícias e Artigos</h2>
            </div>
            
            
            <?php foreach($noticias AS $noticia):?>
            <!-- blog-item -->
            <div class="col-lg-4 col-sm-6 mb-4">
                <article class="card">
                    <a href="noticia.php?id=<?php echo codifica($noticia["codigo_noticia"]);?>">
                    <div class="card-img-wrapper overlay-rounded-top">
                    <a href="noticia.php?id=<?php echo codifica($noticia["codigo_noticia"]);?>"><img class="card-img-top" src="conteudos/noticia/<?php echo $noticia["arquivo"];?>" alt="blog-thumbnail"></a>
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


<!-- client logo slider -->
<section class="bg-gray py-4">
    <div class="container">
        <div class="client-logo-slider align-self-center">
            
            <a href="http://demo.themefisher.com/themefisher/biztrox-hugo" class="text-center d-block outline-0 py-3 px-2"><img class="d-unset" src="images/client-logo/jornal.png"
                    alt="client-logo"></a>
            
            <a href="http://demo.themefisher.com/themefisher/biztrox-hugo" class="text-center d-block outline-0 py-3 px-2"><img class="d-unset" src="images/client-logo/centro.png"
                    alt="client-logo"></a>
            
            <a href="http://demo.themefisher.com/themefisher/biztrox-hugo" class="text-center d-block outline-0 py-3 px-2"><img class="d-unset" src="images/client-logo/auta.png"
                    alt="client-logo"></a>
            
            <a href="http://demo.themefisher.com/themefisher/biztrox-hugo" class="text-center d-block outline-0 py-3 px-2"><img class="d-unset" src="images/client-logo/tvmundial.png"
                    alt="client-logo"></a>
           
        </div>
    </div>
</section>
<!-- /client logo slider -->


<!-- footer -->
<footer class="bg-secondary">
    <?php include "site_mod_rodape.php";?>
</footer>
<!-- /footer -->

<?php include "site_mod_include_js.php";?>

</body>

</html>