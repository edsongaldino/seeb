<?php require_once("../sistema_mod_include.php");?>
<?php
    $msg_erro        = protege(decodifica($_GET["me"]));
    $mensagem        = protege(decodifica($_GET["mm"]));

    //Abre a conexão
    $pdo = Database::conexao();
    
	//consulta noticias
    $sql_consulta_noticias = "SELECT * FROM noticia WHERE noticia.status <> 'E'";
    $result = $pdo->query( $sql_consulta_noticias );
    $noticias = $result->fetchAll( PDO::FETCH_ASSOC );

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

        function removerNoticia(id) {
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
                    window.location.href = "/sistema/sessao_noticia/excluir.php?codigo_noticia="+id;
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

        function removerSubnoticia(id) {
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
                    window.location.href = "/sistema/sessao_noticia/excluir.php?codigo_subnoticia="+id;
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

        function adicionarnoticia(id) {
           swal({
                title: 'Insira o nome da noticia',
                html: '<form id="myForm" method="post" action="/sistema/sessao_noticia/adicionar.php" ><div class="form-group">' +
                        '<input id="input-field" name="nome_noticia" type="text" class="form-control" />' +
                        '<input id="input-field" name="acao" type="hidden" class="form-control" value="<?php echo codifica("adicionar-noticia");?>" />' +
                    '</div></form>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Salvar noticia',
                cancelButtonClass: 'btn btn-danger',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function(result) {
                    $('#myForm').submit();
                }).catch(swal.noop)
        }

        function adicionarSubnoticia(id) {
           swal({
                title: 'Insira o nome da subnoticia',
                html: '<form id="myForm" method="post" action="/sistema/sessao_noticia/adicionar.php" ><div class="form-group">' +
                        '<select id="noticia" name="noticia" class="form-control">'+
                        '<option value="">Selecione uma noticia</opstion>'+
                        <?php foreach($noticias AS $noticia_select):?>
                        '<option value="<?php echo $noticia_select["codigo_noticia"];?>"><?php echo $noticia_select["nome_noticia"];?></opstion>'+
                        <?php endforeach; ?>
                        '</select>'+
                        '<input id="input-field" name="nome_subnoticia" type="text" class="form-control" />' +
                        '<input id="input-field" name="acao" type="hidden" class="form-control" value="<?php echo codifica("adicionar-subnoticia");?>" />' +
                    '</div></form>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Salvar Subnoticia',
                cancelButtonClass: 'btn btn-danger',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function(result) {
                    $('#myForm').submit();
                }).catch(swal.noop)
        }

        /*
        function adicionarnoticia(id){
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

        function adicionarSubnoticia(id){
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
                                
                                
                                <a href="sessao_noticia/adicionar.php">
                                <button type="button" rel="tooltip" class="btn btn-info">
                                            <span class="btn-label">
                                            <i class="material-icons">add</i>
                                            </span>
                                            ADICIONAR PUBLICAÇÃO
                                        <div class="ripple-container"></div>
                                </button>
                                </a>


                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">noticias</h4>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Título do noticia</th>
                                                        <th class="text-right">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($noticias AS $noticia):?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $noticia["codigo_noticia"];?></td>
                                                        <td><?php echo $noticia["titulo"];?></td>
                                                        <td class="td-actions text-right">
                                                            <a href="sessao_noticia/editar.php?codigo_noticia=<?php echo codifica($noticia["codigo_noticia"]);?>">
                                                                <button type="button" rel="tooltip" class="btn btn-info">
                                                                    <i class="material-icons">create</i>
                                                                </button>
                                                            </a>

                                                            
                                                            <button type="button" rel="tooltip" class="btn btn-danger" onclick="removerNoticia('<?php echo codifica($noticia["codigo_noticia"]);?>')">
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