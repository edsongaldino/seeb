<?php require_once("../sistema_mod_include.php");?>
<?php
    $msg_erro        = protege(decodifica($_GET["me"]));
    $mensagem        = protege(decodifica($_GET["mm"]));

    //Abre a conexão
	$pdo = Database::conexao();
	//consulta representantes
    $sql_consulta_representantes = "SELECT * FROM representante";
    $result = $pdo->query( $sql_consulta_representantes );
	$total_representantes = $result->rowCount();
    $representantes = $result->fetchAll( PDO::FETCH_ASSOC );
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

        function confirmacao(id) {
           swal({
                    title: 'Deseja remover este item?',
                    text: 'Tenha certeza que deseja remover este representante, não haverá como restaurá-lo.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, pode excluir!',
                    cancelButtonText: 'Não, quero manter',
                    confirmButtonClass: "btn btn-success",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false
                }).then(function() {
                    window.location.href = "/sistema/sessao_representante/excluir.php?codigo_representante="+id;
                }, function(dismiss) {
                  // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                  if (dismiss === 'cancel') {
                    swal({
                      title: 'Operação cancelada',
                      text: 'Seu representante será mantido :)',
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
                    <div class="row">
                    
                        <div class="col-md-12">

                            <a href="sessao_representante/adicionar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">add</i>
                                        </span>
                                        ADICIONAR REPRESENTANTE
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">work</i>
                                </div>
                                <h4 class="card-title">Representantes</h4>
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Nome do Representante</th>
                                                    <th>Telefone</th>
                                                    <th>E-mail</th>
                                                    <th class="text-right">Região</th>
                                                    <th class="text-right">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($representantes AS $representante):?>
                                                <tr>
                                                    <td class="text-center"><?php echo $representante["codigo_representante"];?></td>
                                                    <td><?php echo $representante["nome_representante"];?></td>
                                                    <td><?php echo $representante["nome_representante"];?></td>
                                                    <td><?php echo $representante["nome_representante"];?></td>
                                                    <td class="text-right"><?php echo $representante["nome_representante"];?></td>
                                                    <td class="td-actions text-right">
                                                        <button type="button" rel="tooltip" class="btn btn-info" onclick="window.open('sessao_representante/fotos_representante.php?codigo_representante=<?php echo codifica($representante["codigo_representante"]);?>', '_self')">
                                                            <i class="material-icons">camera_enhance</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" class="btn btn-success" onclick="window.open('sessao_representante/editar.php?codigo_representante=<?php echo codifica($representante["codigo_representante"]);?>', '_self')">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" class="btn btn-danger" onclick="confirmacao('<?php echo codifica($representante["codigo_representante"]);?>')">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <footer class="footer">
                <?php include_once("../sistema_mod_footer.php");?>
            </footer>
        </div>
    </div>
    <?php require_once("../sistema_include_configuracoes.php"); ?>
</body>
<?php require_once("../sistema_include_js.php"); ?>

</html>