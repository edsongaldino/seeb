<?php require_once("../sistema_mod_include.php");?>
<?php
    $msg_erro        = protege(decodifica($_GET["me"]));
    $mensagem        = protege(decodifica($_GET["mm"]));

    //Abre a conexão
    $pdo = Database::conexao();
    
	//consulta categorias
    $sql_consulta_categorias = "SELECT codigo_categoria, nome_categoria, status FROM categoria WHERE status = 'L' ORDER BY nome_categoria ASC";
    $result = $pdo->query( $sql_consulta_categorias );
    $categorias = $result->fetchAll( PDO::FETCH_ASSOC );

    //consulta subcategorias
    $sql_consulta_subcategorias = "SELECT subcategoria.codigo_subcategoria, subcategoria.nome_subcategoria, subcategoria.status, categoria.nome_categoria FROM subcategoria JOIN categoria ON categoria.codigo_categoria = subcategoria.codigo_categoria WHERE subcategoria.status = 'L' ORDER BY nome_subcategoria ASC";
    $result = $pdo->query( $sql_consulta_subcategorias );
    $subcategorias = $result->fetchAll( PDO::FETCH_ASSOC );
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

        function removerCategoria(id) {
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
                    window.location.href = "/sistema/sessao_categoria/excluir.php?codigo_categoria="+id;
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

        function removerSubcategoria(id) {
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
                    window.location.href = "/sistema/sessao_categoria/excluir.php?codigo_subcategoria="+id;
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

        function adicionarCategoria(id) {
           swal({
                title: 'Insira o nome da categoria',
                html: '<form id="myForm" method="post" action="/sistema/sessao_categoria/adicionar.php" ><div class="form-group">' +
                        '<input id="input-field" name="nome_categoria" type="text" class="form-control" />' +
                        '<input id="input-field" name="acao" type="hidden" class="form-control" value="<?php echo codifica("adicionar-categoria");?>" />' +
                    '</div></form>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Salvar Categoria',
                cancelButtonClass: 'btn btn-danger',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function(result) {
                    $('#myForm').submit();
                }).catch(swal.noop)
        }

        function adicionarSubcategoria(id) {
           swal({
                title: 'Insira o nome da subcategoria',
                html: '<form id="myForm" method="post" action="/sistema/sessao_categoria/adicionar.php" ><div class="form-group">' +
                        '<select id="categoria" name="categoria" class="form-control">'+
                        '<option value="">Selecione uma categoria</opstion>'+
                        <?php foreach($categorias AS $categoria_select):?>
                        '<option value="<?php echo $categoria_select["codigo_categoria"];?>"><?php echo $categoria_select["nome_categoria"];?></opstion>'+
                        <?php endforeach; ?>
                        '</select>'+
                        '<input id="input-field" name="nome_subcategoria" type="text" class="form-control" />' +
                        '<input id="input-field" name="acao" type="hidden" class="form-control" value="<?php echo codifica("adicionar-subcategoria");?>" />' +
                    '</div></form>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Salvar Subcategoria',
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


                            


                            <div class="col-md-6">


                                <button type="button" rel="tooltip" class="btn btn-info" onclick="adicionarCategoria();">
                                            <span class="btn-label">
                                            <i class="material-icons">add</i>
                                            </span>
                                            ADICIONAR CATEGORIA
                                        <div class="ripple-container"></div>
                                </button>


                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">Categorias</h4>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Nome da categoria</th>
                                                        <th class="text-right">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($categorias AS $categoria):?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $categoria["codigo_categoria"];?></td>
                                                        <td><?php echo $categoria["nome_categoria"];?></td>
                                                        <td class="td-actions text-right">
                                                            <a href="sessao_categoria/editar.php?codigo_categoria=<?php echo codifica($categoria["codigo_categoria"]);?>">
                                                                <button type="button" rel="tooltip" class="btn btn-info">
                                                                    <i class="material-icons">create</i>
                                                                </button>
                                                            </a>
                                                            <button type="button" rel="tooltip" class="btn btn-danger" onclick="removerCategoria('<?php echo codifica($categoria["codigo_categoria"]);?>')">
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

                            <div class="col-md-6">
                                
                                <button type="button" rel="tooltip" class="btn btn-info" onclick="adicionarSubcategoria();">
                                            <span class="btn-label">
                                            <i class="material-icons">add</i>
                                            </span>
                                            ADICIONAR SUBCATEGORIA
                                        <div class="ripple-container"></div>
                                </button>
                                
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">Subcategorias</h4>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Categoria</th>
                                                        <th>Nome da Subcategoria</th>
                                                        <th class="text-right">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($subcategorias AS $subcategoria):?>
                                                <tr>
                                                    <td class="text-center"><?php echo $subcategoria["codigo_subcategoria"];?></td>
                                                    <td><?php echo $subcategoria["nome_categoria"];?></td>
                                                    <td><?php echo $subcategoria["nome_subcategoria"];?></td>
                                                    <td class="td-actions text-right">
                                                        <a href="sessao_categoria/editar.php?codigo_subcategoria=<?php echo codifica($subcategoria["codigo_subcategoria"]);?>">
                                                        <button type="button" rel="tooltip" class="btn btn-info">
                                                        <i class="material-icons">create</i>
                                                        </button>
                                                        </a>
                                                        <button type="button" rel="tooltip" class="btn btn-danger" onclick="removerSubcategoria('<?php echo codifica($subcategoria["codigo_subcategoria"]);?>')">
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