<?php require_once("../sistema_mod_include.php");?>
<?php
    $msg_erro        = protege(decodifica($_GET["me"]));
    $mensagem        = protege(decodifica($_GET["mm"]));
    $codigo_envio    = protege(decodifica($_GET["codigo_envio"]));

    //Abre a conexão
    $pdo = Database::conexao();
    
	//consulta envios
    $sql_consulta_envios = "SELECT
    emkt_envio.codigo_emkt_tipo_envio,
    emkt_envio_contato.codigo_emkt_envio_contato,
    emkt_envio_contato.data_emkt_envio_contato,
    emkt_envio_contato.situacao_emkt_envio_contato,
    emkt_envio_contato.data_leitura_emkt_envio_contato,
    emkt_contato.nome_emkt_contato,
    emkt_contato.email_emkt_contato,
    emkt_contato.codigo_emkt_contato
    FROM emkt_envio
    JOIN emkt_envio_contato ON emkt_envio_contato.codigo_emkt_envio = emkt_envio.codigo_emkt_envio
    JOIN emkt_contato ON emkt_envio_contato.codigo_emkt_contato = emkt_contato.codigo_emkt_contato
    WHERE emkt_envio.codigo_emkt_envio = '".$codigo_envio."'";
    $result = $pdo->query( $sql_consulta_envios );
    $envios = $result->fetchAll( PDO::FETCH_ASSOC );

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
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header" data-background-color="orange">
                                                <i class="material-icons">network_cell</i>
                                            </div>
                                            <div class="card-content">
                                                <p class="category">Total de Envios desta campanha</p>
                                                <h3 class="card-title"><?php echo total_envios_campanha($codigo_envio);?></h3>
                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                <i class="material-icons">info</i> Envios somente desta campanha
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header" data-background-color="green">
                                                <i class="material-icons">cached</i>
                                            </div>
                                            <div class="card-content">
                                                <p class="category">Envios Pendentes</p>
                                                <h3 class="card-title"><?php echo total_envios_pendentes($codigo_envio);?></h3>
                                            </div>
                                            <div class="card-footer">
                                                <div class="stats">
                                                    <i class="material-icons">restore</i> Envios sendo realizados neste momento
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="card card-stats">
                                            <div class="card-header" data-background-color="blue">
                                                <i class="material-icons">visibility</i>
                                            </div>
                                            <div class="card-content">
                                                <p class="category">Visualizações</p>
                                                <h3 class="card-title"><?php echo total_visualizacoes_envio($codigo_envio);?></h3>
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
                                                        <th>Data do envio</th>
                                                        <th>Nome</th>
                                                        <th>E-mail</th>
                                                        <th>Situação</th>
                                                        <th>Data/Hora da Visualização</th>
                                                        <th class="text-right">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($envios AS $envio):?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $envio["codigo_emkt_envio"];?></td>
                                                        <td><?php echo $envio["data_emkt_envio_contato"];?></td>
                                                        <td><?php echo $envio["nome_emkt_contato"];?></td>
                                                        <td><?php echo $envio["email_emkt_contato"];?></td>
                                                        <td><?php echo $envio["situacao_emkt_envio_contato"];?></td>
                                                        <td><?php echo $envio["data_leitura_emkt_envio_contato"];?></td>
                                                        <td class="td-actions text-right">
                                                            <button type="button" rel="tooltip" class="btn btn-warning"  title="Reenviar para este contato" onclick="adicionarEnvio('<?php echo codifica($envio["codigo_emkt_envio"]);?>')">
                                                                <i class="material-icons">send</i>
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