<?php require_once("../sistema_mod_include.php");?>
<?php
    $msg_erro        = protege(decodifica($_GET["me"]));
    $mensagem        = protege(decodifica($_GET["mm"]));

    //Abre a conexão
    $pdo = Database::conexao();
    
	//consulta envios
    $sql_consulta_envios = "SELECT emkt_envio.codigo_emkt_envio, emkt_envio.codigo_emkt_tipo_envio, emkt_envio.titulo_emkt_envio, emkt_envio.data_emkt_envio, emkt_envio.status_emkt_envio, emkt_tipo_envio.descricao_emkt_tipo_envio
                                FROM emkt_envio 
                                JOIN emkt_tipo_envio ON emkt_tipo_envio.codigo_emkt_tipo_envio = emkt_envio.codigo_emkt_tipo_envio
                                WHERE emkt_envio.status_emkt_envio = 'L' ORDER BY emkt_envio.data_emkt_envio DESC";
    $result = $pdo->query( $sql_consulta_envios );
    $envios = $result->fetchAll( PDO::FETCH_ASSOC );

    //consulta grupos
    $sql_consulta_grupos = "SELECT codigo_emkt_grupo, titulo_emkt_grupo, status_emkt_grupo FROM emkt_grupo ORDER BY titulo_emkt_grupo ASC";
    $result_grupos = $pdo->query( $sql_consulta_grupos );
    $grupos = $result_grupos->fetchAll( PDO::FETCH_ASSOC );

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

        function removerenvio(id) {
           swal({
                    title: 'Deseja remover este item?',
                    text: 'Tenha certeza que deseja remover este item, não haverá como restaurá-lo.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, pode excluir!',
                    cancelButtonText: 'Não, quero manter',
                    confirmButtonClass: "btn btn-success",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false
                }).then(function() {
                    window.location.href = "/sistema/sessao_emailmarketing/excluir.php?codigo_envio="+id;
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

        function adicionarEnvio(id) {
           swal({
                title: 'Selecione um grupo para enviar',
                html: '<form id="myForm" method="post" action="/sistema/sessao_emailmarketing/adicionar.php" ><div class="form-group">' +
                        '<select id="grupo" name="grupo" class="form-control">'+
                        '<option value="" selected disabled>Selecione um grupo</opstion>'+
                        <?php foreach($grupos AS $grupo_select):?>
                        '<option value="<?php echo $grupo_select["codigo_emkt_grupo"];?>"><?php echo $grupo_select["titulo_emkt_grupo"];?></opstion>'+
                        <?php endforeach; ?>
                        '</select>'+
                      '<input id="input-field" name="acao" type="hidden" class="form-control" value="<?php echo codifica("adicionar-envio");?>" />' +
                      '<input id="input-field" name="codigo_envio" type="hidden" class="form-control" value="'+id+'" />' +
                      '</div></form>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Enviar para o grupo selecionado',
                cancelButtonClass: 'btn btn-danger',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function(result) {
                    $('#myForm').submit();
                }).catch(swal.noop)
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


                            


                            <div class="col-md-12">


                                <a href="sessao_emailmarketing/novo_envio.php">
                                <button type="button" rel="tooltip" class="btn btn-info">
                                            <span class="btn-label">
                                            <i class="material-icons">add</i>
                                            </span>
                                            NOVO ENVIO
                                        <div class="ripple-container"></div>
                                </button>
                                </a>

                                <a href="sessao_emailmarketing/grupos_contatos.php">
                                <button type="button" rel="tooltip" class="btn btn-warning">
                                            <span class="btn-label">
                                            <i class="material-icons">perm_identity</i>
                                            </span>
                                            GRUPOS / CONTATOS
                                        <div class="ripple-container"></div>
                                </button>
                                </a>

                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header" data-background-color="orange">
                                                <i class="material-icons">network_cell</i>
                                            </div>
                                            <div class="card-content">
                                                <p class="category">Quantidade de envios restantes</p>
                                                <h3 class="card-title"><?php echo (100-total_envios_mkt_mes());?></h3>
                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                <i class="material-icons">info</i> De acordo com o limite de envios mensal
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header" data-background-color="rose">
                                                <i class="material-icons">equalizer</i>
                                            </div>
                                            <div class="card-content">
                                                <p class="category">Total de envios no mês</p>
                                                <h3 class="card-title"><?php echo total_envios_mkt_mes();?></h3>
                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">local_offer</i> Mês Atual
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header" data-background-color="green">
                                                <i class="material-icons">cached</i>
                                            </div>
                                            <div class="card-content">
                                                <p class="category">Envios Ativos</p>
                                                <h3 class="card-title"><?php echo total_envios_ativos();?></h3>
                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">restore</i> Envios sendo realizados neste momento
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header" data-background-color="blue">
                                                <i class="material-icons">visibility</i>
                                            </div>
                                            <div class="card-content">
                                                <p class="category">Visualizações</p>
                                                <h3 class="card-title"><?php echo total_envios_visualizados();?></h3>
                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">touch_app</i> Quantidade de usuários que visualizaram
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">Envios</h4>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Título</th>
                                                        <th>Data</th>
                                                        <th>Tipo</th>
                                                        <th>Situação</th>
                                                        <th class="text-right">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($envios AS $envio):?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $envio["codigo_emkt_envio"];?></td>
                                                        <td><?php echo $envio["titulo_emkt_envio"];?></td>
                                                        <td><?php echo $envio["data_emkt_envio"];?></td>
                                                        <td><?php echo $envio["descricao_emkt_tipo_envio"];?></td>
                                                        <td><?php echo $envio["status_emkt_envio"];?></td>
                                                        <td class="td-actions text-right">
                                                            <a href="sessao_emailmarketing/relatorio.php?codigo_envio=<?php echo codifica($envio["codigo_emkt_envio"]);?>">
                                                                <button type="button" rel="tooltip" title="Relatório de Envio" class="btn btn-dribbble">
                                                                    <i class="material-icons">equalizer</i>
                                                                </button>
                                                            </a>
                                                            <?php if($envio["codigo_emkt_tipo_envio"] == 2):?>
                                                            <a href="sessao_emailmarketing/produtos_envio.php?codigo_emkt_envio=<?php echo codifica($envio["codigo_emkt_envio"]);?>">
                                                            <button type="button" rel="tooltip" class="btn btn-secondary" title="Selecione os produtos que deseja enviar">
                                                                <i class="material-icons">shopping_basket</i>
                                                            </button>
                                                            </a>
                                                            <?php endif;?>
                                                            <button type="button" rel="tooltip" class="btn btn-warning"  title="Enviar E-mail Marketing" onclick="adicionarEnvio('<?php echo codifica($envio["codigo_emkt_envio"]);?>')">
                                                                <i class="material-icons">send</i>
                                                            </button>
                                                            <a href="sessao_emailmarketing/editar.php?codigo_envio=<?php echo codifica($envio["codigo_emkt_envio"]);?>">
                                                                <button type="button" rel="tooltip" title="Editar envio" class="btn btn-info">
                                                                    <i class="material-icons">create</i>
                                                                </button>
                                                            </a>
                                                            <button type="button" rel="tooltip" class="btn btn-danger" title="Remover envio" onclick="removerenvio('<?php echo codifica($envio["codigo_emkt_envio"]);?>')">
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