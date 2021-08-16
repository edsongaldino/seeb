<?php require_once("../sistema_mod_include.php");?>
<?php
    $msg_erro        = protege(decodifica($_GET["me"]));
    $mensagem        = protege(decodifica($_GET["mm"]));

    $codigo_grupo        = protege(decodifica($_GET["codigo_grupo"]));

    //Abre a conexão
    $pdo = Database::conexao();
    
	//consulta grupos
    $sql_consulta_grupo = "SELECT codigo_emkt_grupo, titulo_emkt_grupo, status_emkt_grupo FROM emkt_grupo WHERE codigo_emkt_grupo = '".$codigo_grupo."'";
    $result = $pdo->query( $sql_consulta_grupo );
    $grupo = $result->fetch( PDO::FETCH_ASSOC );

    //consulta contatos
    $sql_consulta_contatos = "SELECT emkt_contato.codigo_emkt_contato, emkt_contato.nome_emkt_contato, emkt_contato.email_emkt_contato, emkt_contato.status_emkt_contato FROM emkt_contato 
    JOIN emkt_grupo_contato ON emkt_grupo_contato.codigo_emkt_contato = emkt_contato.codigo_emkt_contato
    WHERE emkt_grupo_contato.codigo_emkt_grupo = '".$codigo_grupo."' ORDER BY nome_emkt_contato ASC";
    $result = $pdo->query( $sql_consulta_contatos );
    $contatos = $result->fetchAll( PDO::FETCH_ASSOC );


    //consulta grupos
    $sql_consulta_grupos = "SELECT codigo_emkt_grupo, titulo_emkt_grupo, status_emkt_grupo FROM emkt_grupo ORDER BY titulo_emkt_grupo ASC";
    $result = $pdo->query( $sql_consulta_grupos );
    $grupos = $result->fetch( PDO::FETCH_ASSOC );
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

        function removerGrupo(id) {
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
                    window.location.href = "/sistema/sessao_emailmarketing/excluir.php?codigo_grupo="+id;
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

        function removercontato(id) {
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
                    window.location.href = "/sistema/sessao_emailmarketing/excluir.php?codigo_contato="+id;
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

        function adicionarGrupo(id) {
           swal({
                title: 'Insira o nome do grupo',
                html: '<form id="myForm" method="post" action="/sistema/sessao_emailmarketing/adicionar.php" ><div class="form-group">' +
                        '<input id="input-field" name="nome_grupo" type="text" class="form-control" />' +
                        '<input id="input-field" name="acao" type="hidden" class="form-control" value="<?php echo codifica("adicionar-grupo");?>" />' +
                    '</div></form>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Salvar Grupo',
                cancelButtonClass: 'btn btn-danger',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function(result) {
                    $('#myForm').submit();
                }).catch(swal.noop)
        }

        function adicionarContato(id) {
           swal({
                title: 'Insira os dados do contato',
                html: '<form id="myForm" method="post" action="/sistema/sessao_emailmarketing/adicionar.php" ><div class="form-group">' +
                        '<select id="grupo" name="grupo" class="form-control">'+
                        '<option value="">Selecione um grupo</opstion>'+
                        <?php foreach($grupos AS $grupo_select):?>
                        '<option value="<?php echo $grupo_select["codigo_emkt_grupo"];?>"><?php echo $grupo_select["titulo_emkt_grupo"];?></option>'+
                        <?php endforeach; ?>
                        '</select>'+
                        '<input id="input-field" placeholder="Nome completo" name="nome_contato" type="text" class="form-control" required />' +
                        '<input id="input-field" name="email_contato" placeholder="E-mail" type="email" class="form-control" required />' +
                        '<input id="input-field" name="acao" type="hidden" class="form-control" value="<?php echo codifica("adicionar-contato");?>" />' +
                    '</div></form>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Salvar Contato',
                cancelButtonClass: 'btn btn-danger',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function(result) {
                    $('#myForm').submit();
                }).catch(swal.noop)
        }

        /*
        function adicionarCategoria(id){
            swal({
                    title: 'Input something',
                    html: '<div class="form-group">' +
                              '<input id="input-field" type="text" class="form-control" />' +
                          '</div>',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function(result) {
                    swal({
                        type: 'success',
                        html: 'You entered: <strong>' +
                                $('#input-field').val() +
                              '</strong>',
                        confirmButtonClass: 'btn btn-success',
                        buttonsStyling: false

                    })
                }).catch(swal.noop)
            }
        }

        function adicionarSubcategoria(id){
            swal({
                    title: 'Input something',
                    html: '<div class="form-group">' +
                              '<input id="input-field" type="text" class="form-control" />' +
                          '</div>',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function(result) {
                    swal({
                        type: 'success',
                        html: 'You entered: <strong>' +
                                $('#input-field').val() +
                              '</strong>',
                        confirmButtonClass: 'btn btn-success',
                        buttonsStyling: false

                    })
                }).catch(swal.noop)
            }
        }*/
        
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

                                <button class="btn btn-warning">
                                            <span class="btn-label">
                                            <i class="material-icons">supervised_user_circle</i>
                                            </span>
                                            <?php echo $grupo["titulo_emkt_grupo"];?>
                                        <div class="ripple-container"></div>
                                </button>

                                <a href="sessao_emailmarketing/consultar.php">
                                    <button class="btn btn-info">
                                                <span class="btn-label">
                                                <i class="material-icons">reply</i>
                                                </span>
                                                VOLTAR
                                            <div class="ripple-container"></div>
                                    </button>
                                </a>


                                <button type="button" rel="tooltip" class="btn btn-success" onclick="adicionarContato();">
                                            <span class="btn-label">
                                            <i class="material-icons">add</i>
                                            </span>
                                            ADICIONAR CONTATO
                                        <div class="ripple-container"></div>
                                </button>

                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">Contatos</h4>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Nome contato</th>
                                                        <th>E-mail</th>
                                                        <th class="text-right">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($contatos AS $contato):?>
                                                <tr>
                                                    <td class="text-center"><?php echo $contato["codigo_emkt_contato"];?></td>
                                                    <td><?php echo $contato["nome_emkt_contato"];?></td>
                                                    <td><?php echo $contato["email_emkt_contato"];?></td>
                                                    <td class="td-actions text-right">
                                                        <a href="sessao_emailmarketing/editar_grupocontato.php?codigo_emkt_contato=<?php echo codifica($contato["codigo_emkt_contato"]);?>">
                                                        <button type="button" rel="tooltip" class="btn btn-info">
                                                        <i class="material-icons">create</i>
                                                        </button>
                                                        </a>
                                                        <button type="button" rel="tooltip" class="btn btn-danger" onclick="removercontato('<?php echo codifica($contato["codigo_emkt_contato"]);?>')">
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