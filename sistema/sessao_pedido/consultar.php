<?php require_once("../sistema_mod_include.php");?>
<?php
    $msg_erro        = protege(decodifica($_GET["me"]));
    $mensagem        = protege(decodifica($_GET["mm"]));

    //Abre a conexão
	$pdo = Database::conexao();
	//consulta pedidos
    $sql_consulta_pedidos = "SELECT pedido.*, site_usuario.* FROM pedido JOIN site_usuario ON pedido.codigo_site_usuario = site_usuario.codigo_site_usuario GROUP BY pedido.codigo_pedido ORDER BY pedido.codigo_pedido DESC";
    $result = $pdo->query( $sql_consulta_pedidos );
	$total_pedido = $result->rowCount();
    $pedidos = $result->fetchAll( PDO::FETCH_ASSOC );
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
                    text: 'Tenha certeza que deseja remover este pedido, não haverá como restaurá-lo.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, pode excluir!',
                    cancelButtonText: 'Não, quero manter',
                    confirmButtonClass: "btn btn-success",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false
                }).then(function() {
                    window.location.href = "/sistema/sessao_pedido/excluir.php?codigo_pedido="+id;
                }, function(dismiss) {
                  // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                  if (dismiss === 'cancel') {
                    swal({
                      title: 'Operação cancelada',
                      text: 'Seu pedido será mantido :)',
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
                            
                            <!--
                            <a href="sessao_pedido/adicionar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">add</i>
                                        </span>
                                        ADICIONAR pedido
                                    <div class="ripple-container"></div>
                            </button>
                            </a>-->

                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">view_list</i>
                                </div>
                                <h4 class="card-title">Gerenciamento de Pedidos</h4>
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Nome do Cliente</th>
                                                    <th>E-mail</th>
                                                    <th>Telefone</th>
                                                    <th>Data do Pedido</th>
                                                    <th class="text-right">Valor Total</th>
                                                    <th class="text-right">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($pedidos AS $pedido):?>
                                                <tr>
                                                    <td class="text-center"><?php echo $pedido["codigo_pedido"];?></td>
                                                    <td><?php echo $pedido["nome_site_usuario"];?></td>
                                                    <td><?php echo $pedido["email_site_usuario"];?></td>
                                                    <td><?php echo $pedido["telefone_site_usuario"];?></td>
                                                    <td><?php echo converte_data_portugues($pedido["data_pedido"]);?> (<?php echo $pedido["hora_pedido"];?>)</td>
                                                    <td class="text-right">R$ <?php echo $pedido["total_pedido"];?></td>
                                                    <td class="td-actions text-right">
                                                        <button type="button" title="Itens do Pedido" rel="tooltip" class="btn btn-info" onclick="window.open('sessao_pedido/itens_pedido.php?codigo_pedido=<?php echo codifica($pedido["codigo_pedido"]);?>', '_self')">
                                                        <i class="material-icons">list</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" title="Editar Pedido" class="btn btn-success" onclick="window.open('sessao_pedido/editar.php?codigo_pedido=<?php echo codifica($pedido["codigo_pedido"]);?>', '_self')">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" title="Excluir Pedido" class="btn btn-danger" onclick="confirmacao('<?php echo codifica($pedido["codigo_pedido"]);?>')">
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