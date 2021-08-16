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

    <script type="text/javascript">
        window.onload = function(){
            <?php if($msg_erro){ ?>
                demo.showNotification('top','center', 'warning', '<?php echo $mensagem;?>');
            <?php }elseif($_GET["mm"]){ ?>
                demo.showNotification('top','center', 'success', '<?php echo $mensagem;?>');
            <?php } ?>
        }

        function removerFoto(id) {
           swal({
                    title: 'Deseja remover esta imagem?',
                    text: 'Tenha certeza que deseja remover esta imagem? Não haverá como restaurá-la.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, pode excluir!',
                    cancelButtonText: 'Não, quero manter',
                    confirmButtonClass: "btn btn-success",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false
                }).then(function() {
                    window.location.href = "/sistema/sessao_produto/excluir.php?codigo_foto="+id;
                }, function(dismiss) {
                  // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                  if (dismiss === 'cancel') {
                    swal({
                      title: 'Operação cancelada',
                      text: 'O item será mantido :)',
                      type: 'error',
                      confirmButtonClass: "btn btn-info",
                      buttonsStyling: false
                    })
                  }
                })
        }

        function updateFoto(id) {
           swal({
                    title: 'Deseja definir esta imagem como destaque?',
                    text: 'Esta imagem aparecerá na capa da galeria',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, destacar imagem!',
                    cancelButtonText: 'Não, cancele',
                    confirmButtonClass: "btn btn-success",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false
                }).then(function() {
                    window.location.href = "/sistema/sessao_produto/update.php?codigo_foto="+id;
                }, function(dismiss) {
                  // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                  if (dismiss === 'cancel') {
                    swal({
                      title: 'Operação cancelada',
                      text: 'Nada foi alterado :)',
                      type: 'error',
                      confirmButtonClass: "btn btn-info",
                      buttonsStyling: false
                    })
                  }
                })
        }

        
        
    </script>
</head>

<body>
    <div class="wrapper">
        <?php include_once("../sistema_mod_lateral.php");?>
        <div class="main-panel">
            <?php include_once("../sistema_mod_topo.php");?>
            <div class="content">
                <div class="container-fluid">
                    <h3>Fotos do Produto</h3>
                    <br>
                    <a href="sessao_produto/adicionar_fotos.php?codigo_produto=<?php echo codifica($codigo_produto);?>">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">add</i>
                                        </span>
                                        ADICIONAR FOTOS
                                    <div class="ripple-container"></div>
                            </button>
                        </a>
                    <br>
                    <br>
                    <br>
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
                                        <button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Definir como Destaque" onclick="updateFoto('<?php echo codifica($foto_produto["codigo_foto"]);?>')">
                                            <i class="material-icons">star_rate</i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-simple" rel="tooltip" data-placement="bottom" title="Remover" onclick="removerFoto('<?php echo codifica($foto_produto["codigo_foto"]);?>')">
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