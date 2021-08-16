<?php require_once("../sistema_mod_include.php");?>
<?php
    $msg_erro        = protege(decodifica($_GET["me"]));
    $mensagem        = protege(decodifica($_GET["mm"]));

    //Abre a conexão
    $pdo = Database::conexao();
    
	//consulta escolas
    $sql_consulta_escolas = "SELECT escola.codigo_escola, escola.titulo_escola, escola.status FROM escola WHERE escola.status <> 'E'";
    $result = $pdo->query( $sql_consulta_escolas );
    $escolas = $result->fetchAll( PDO::FETCH_ASSOC );

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

        function removerescola(id) {
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
                    window.location.href = "/sistema/sessao_escola/excluir.php?codigo_escola="+id;
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

        function removerSubescola(id) {
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
                    window.location.href = "/sistema/sessao_escola/excluir.php?codigo_subescola="+id;
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

        function adicionarescola(id) {
           swal({
                title: 'Insira o nome da escola',
                html: '<form id="myForm" method="post" action="/sistema/sessao_escola/adicionar.php" ><div class="form-group">' +
                        '<input id="input-field" name="nome_escola" type="text" class="form-control" />' +
                        '<input id="input-field" name="acao" type="hidden" class="form-control" value="<?php echo codifica("adicionar-escola");?>" />' +
                    '</div></form>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Salvar escola',
                cancelButtonClass: 'btn btn-danger',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function(result) {
                    $('#myForm').submit();
                }).catch(swal.noop)
        }

        function adicionarTurma(id) {
           swal({
                title: 'Insira o nome da turma',
                html: '<form id="myForm" method="post" action="/sistema/sessao_escola/adicionar_turma.php" ><div class="form-group">' +
                        '<select id="escola" name="escola" class="form-control">'+
                        '<option value="">Selecione uma escola</opstion>'+
                        <?php foreach($escolas AS $escola_select):?>
                        '<option value="<?php echo $escola_select["codigo_escola"];?>"><?php echo $escola_select["titulo_escola"];?></opstion>'+
                        <?php endforeach; ?>
                        '</select>'+
                        '<select id="nivel_turma" name="nivel_turma" class="form-control">'+
                        '<option value="">Selecione o nível</opstion>'+
                        '<option value="EI">Educação Infantil</opstion>'+
                        '<option value="EF">Ensino Fundamental</opstion>'+
                        '<option value="EM">Ensino Médio</opstion>'+
                        '</select>'+
                        '<input id="input-field" name="nome_turma" type="text" class="form-control" placeholder="Nome da turma" />' +
                        '<input id="input-field" name="acao" type="hidden" class="form-control" value="<?php echo codifica("adicionar-turma");?>" />' +
                    '</div></form>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Salvar Turma',
                cancelButtonClass: 'btn btn-danger',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function(result) {
                    $('#myForm').submit();
                }).catch(swal.noop)
        }

        /*
        function adicionarescola(id){
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

        function adicionarSubescola(id){
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

                                <a href="sessao_escola/adicionar.php">
                                <button type="button" rel="tooltip" class="btn btn-info">
                                            <span class="btn-label">
                                            <i class="material-icons">school </i>
                                            </span>
                                             ADICIONAR ESCOLA
                                        <div class="ripple-container"></div>
                                </button>
                                </a>

                                <button type="button" rel="tooltip" class="btn btn-warning" onclick="adicionarTurma();">
                                            <span class="btn-label">
                                            <i class="material-icons">add</i>
                                            </span>
                                            ADICIONAR TURMA
                                        <div class="ripple-container"></div>
                                </button>


                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">ESCOLAS</h4>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Título do escola</th>
                                                        <th class="text-right">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($escolas AS $escola):?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $escola["codigo_escola"];?></td>
                                                        <td><?php echo $escola["titulo_escola"];?></td>
                                                        <td class="td-actions text-right">
                                                            <a href="sessao_escola/turmas.php?codigo_escola=<?php echo codifica($escola["codigo_escola"]);?>" title="Visualizar Turmas">
                                                                <button type="button" rel="tooltip" class="btn btn-warning" title="Visualizar Turmas">
                                                                    <i class="material-icons">people</i>
                                                                </button>
                                                            </a>
                                                            <a href="sessao_escola/editar.php?codigo_escola=<?php echo codifica($escola["codigo_escola"]);?>">
                                                                <button type="button" rel="tooltip" class="btn btn-info" title="Editar Escola">
                                                                    <i class="material-icons">create</i>
                                                                </button>
                                                            </a>
                                                            <button type="button" rel="tooltip" class="btn btn-danger" title="Remover Escola" onclick="removerescola('<?php echo codifica($escola["codigo_escola"]);?>')">
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