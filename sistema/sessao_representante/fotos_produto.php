<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
$codigo_produto = protege(decodifica($_GET["codigo_produto"]));

//consulta produtos
$sql_consulta_produto = "SELECT * FROM foto_produto WHERE foto_produto.codigo_produto = '".$codigo_produto."'";
$result = $pdo->query( $sql_consulta_produto );
$fotos_produto = $result->fetchAll( PDO::FETCH_ASSOC );
?>
<!doctype html>
<html lang="pt-br">
<head>
    <?php include_once("../sistema_mod_head.php");?>
</head>

<body>
    <div class="wrapper">
        <?php include_once("../sistema_mod_lateral.php");?>
        <div class="main-panel">
            <?php include_once("../sistema_mod_topo.php");?>
            <div class="content">
                <div class="container-fluid">
                    <h3>Fotos do Produto</h3>
                    <br><br>
                    <div class="row">
                        
                        <?php foreach($fotos_produto AS $foto_produto):?>
                        <div class="col-md-3">
                            <div class="card card-product">
                                <div class="card-image" data-header-animation="true">
                                    <a href="#pablo">
                                        <img class="img" src="../../conteudos/produto/<?php echo $codigo_produto;?>/<?php echo $foto_produto['arquivo_foto'];?>">
                                    </a>
                                </div>
                                <div class="card-content">
                                    <div class="card-actions">
                                        <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                                            <i class="material-icons">build</i> Fix Header!
                                        </button>
                                        <button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Definir como Destaque">
                                            <i class="material-icons">star_rate</i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-simple" rel="tooltip" data-placement="bottom" title="Remover">
                                            <i class="material-icons">close</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>

                        
                        

                    </div>
                </div>
            </div>
            <footer class="footer">
                <?php include_once("../sistema_mod_footer.php");?>
            </footer>
        </div>
    </div>
    <?php include_once("../sistema_include_configuracoes.php"); ?>
</body>
<?php include_once("../sistema_include_js.php"); ?>
</html>