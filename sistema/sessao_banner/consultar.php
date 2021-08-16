<?php require_once("../sistema_mod_include.php");?>
<?php
    $msg_erro        = protege(decodifica($_GET["me"]));
    $mensagem        = protege(decodifica($_GET["mm"]));

    //Abre a conexão
    $pdo = Database::conexao();
    
	//consulta banners
    $sql_consulta_banners = "SELECT banner.codigo_banner, banner.titulo_banner, banner.data_inicial, banner.data_final, banner.status, tipo_banner.descricao_tipo_banner, tipo_banner.tamanho_tipo_banner FROM banner 
    JOIN tipo_banner ON banner.codigo_tipo_banner = tipo_banner.codigo_tipo_banner
    WHERE banner.status <> 'E'";
    $result = $pdo->query( $sql_consulta_banners );
    $banners = $result->fetchAll( PDO::FETCH_ASSOC );

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

        function removerbanner(id) {
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
                    window.location.href = "/sistema/sessao_banner/excluir.php?codigo_banner="+id;
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

        function removerSubbanner(id) {
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
                    window.location.href = "/sistema/sessao_banner/excluir.php?codigo_subbanner="+id;
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

        function adicionarbanner(id) {
           swal({
                title: 'Insira o nome da banner',
                html: '<form id="myForm" method="post" action="/sistema/sessao_banner/adicionar.php" ><div class="form-group">' +
                        '<input id="input-field" name="nome_banner" type="text" class="form-control" />' +
                        '<input id="input-field" name="acao" type="hidden" class="form-control" value="<?php echo codifica("adicionar-banner");?>" />' +
                    '</div></form>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Salvar banner',
                cancelButtonClass: 'btn btn-danger',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function(result) {
                    $('#myForm').submit();
                }).catch(swal.noop)
        }

        function adicionarSubbanner(id) {
           swal({
                title: 'Insira o nome da subbanner',
                html: '<form id="myForm" method="post" action="/sistema/sessao_banner/adicionar.php" ><div class="form-group">' +
                        '<select id="banner" name="banner" class="form-control">'+
                        '<option value="">Selecione uma banner</opstion>'+
                        <?php foreach($banners AS $banner_select):?>
                        '<option value="<?php echo $banner_select["codigo_banner"];?>"><?php echo $banner_select["nome_banner"];?></opstion>'+
                        <?php endforeach; ?>
                        '</select>'+
                        '<input id="input-field" name="nome_subbanner" type="text" class="form-control" />' +
                        '<input id="input-field" name="acao" type="hidden" class="form-control" value="<?php echo codifica("adicionar-subbanner");?>" />' +
                    '</div></form>',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                confirmButtonText: 'Salvar Subbanner',
                cancelButtonClass: 'btn btn-danger',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false
                }).then(function(result) {
                    $('#myForm').submit();
                }).catch(swal.noop)
        }

        /*
        function adicionarbanner(id){
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

        function adicionarSubbanner(id){
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

                                <a href="sessao_banner/adicionar.php">
                                <button type="button" rel="tooltip" class="btn btn-info">
                                            <span class="btn-label">
                                            <i class="material-icons">add</i>
                                            </span>
                                            ADICIONAR BANNER
                                        <div class="ripple-container"></div>
                                </button>
                                </a>


                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">BANNERS</h4>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Título do Banner</th>
                                                        <th>Tipo</th>
                                                        <th>Data Inicial</th>
                                                        <th>Data Final</th>
                                                        <th class="text-right">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($banners AS $banner):?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $banner["codigo_banner"];?></td>
                                                        <td><?php echo $banner["titulo_banner"];?></td>
                                                        <td><?php echo $banner["tamanho_tipo_banner"];?></td>
                                                        <td><?php echo converte_data_portugues($banner["data_inicial"]);?></td>
                                                        <td><?php echo converte_data_portugues($banner["data_final"]);?></td>
                                                        <td class="td-actions text-right">
                                                            <a href="sessao_banner/editar.php?codigo_banner=<?php echo codifica($banner["codigo_banner"]);?>">
                                                                <button type="button" rel="tooltip" class="btn btn-info">
                                                                    <i class="material-icons">create</i>
                                                                </button>
                                                            </a>
                                                            <button type="button" rel="tooltip" class="btn btn-danger" onclick="removerbanner('<?php echo codifica($banner["codigo_banner"]);?>')">
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