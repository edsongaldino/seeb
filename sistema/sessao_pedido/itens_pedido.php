<?php require_once("../sistema_mod_include.php");?>
<?php
    $msg_erro        = protege(decodifica($_GET["me"]));
    $mensagem        = protege(decodifica($_GET["mm"]));
    $codigo_pedido   = protege(decodifica($_GET["codigo_pedido"]));
    //Abre a conexão
    $pdo = Database::conexao();
    
	//consulta escolas
    $sql_consulta_pedido = "SELECT pedido.data_pedido, pedido.hora_pedido, pedido.total_pedido, pedido.status_pedido, site_usuario.nome_site_usuario, site_usuario.email_site_usuario, site_usuario.telefone_site_usuario, site_usuario.codigo_site_usuario
    FROM pedido
    JOIN site_usuario ON site_usuario.codigo_site_usuario = pedido.codigo_site_usuario
    WHERE pedido.codigo_pedido = '".$codigo_pedido."'";
    $result = $pdo->query( $sql_consulta_pedido );
    $pedido = $result->fetch( PDO::FETCH_ASSOC );

    //consulta item_pedido
    $sql_consulta_itens= "SELECT item_pedido.codigo_item_pedido, item_pedido.valor_item_pedido, item_pedido.quantidade_item_pedido, produto.codigo_produto, produto.referencia_produto, produto.nome_produto, foto_produto.arquivo_foto FROM item_pedido
    JOIN produto ON item_pedido.codigo_produto = produto.codigo_produto 
    JOIN foto_produto ON  produto.codigo_produto = foto_produto.codigo_produto
    WHERE item_pedido.codigo_pedido = '".$codigo_pedido."'";
    $result = $pdo->query( $sql_consulta_itens);
    $itens= $result->fetchAll( PDO::FETCH_ASSOC );

?>
<!doctype html>
<html lang="pt-br">
<head>
    <?php include_once("../sistema_mod_head.php");?>
    <script src="assets/js/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        window.onload = function(){
            <?php if($msg_erro){ ?>
                demo.showNotification('top','center', 'warning', '<?php echo $mensagem;?>');
            <?php }elseif($_GET["mm"]){ ?>
                demo.showNotification('top','center', 'success', '<?php echo $mensagem;?>');
            <?php } ?>
        }

        function removerItem(id) {
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
                    window.location.href = "/sistema/sessao_escola/excluir.php?codigo_item_pedido="+id;
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

        
        
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("input[name='codigo_produto']").blur(function(){
            var $nome_produto = $("input[name='nome_produto']");
            var $valor_produto = $("input[name='valor_produto']");

                $.getJSON(
                'sessao_escola/carrega_produto.php',
                { referencia: $( this ).val() },
                function( json )
                {
                    $nome_produto.val( json.nome_produto );
                    $valor_produto.val( json.valor_produto );
                }
                );
            });
        });
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

                                <a href="JavaScript: window.history.back();">
                                    <button class="btn btn-info">
                                                <span class="btn-label">
                                                <i class="material-icons">reply</i>
                                                </span>
                                                VOLTAR
                                            <div class="ripple-container"></div>
                                    </button>
                                </a>

                                <!--
                                <button type="button" rel="tooltip" class="btn btn-warning" onclick="adicionarpedido();">
                                            <span class="btn-label">
                                            <i class="material-icons">add</i>
                                            </span>
                                            ADICIONAR pedido
                                        <div class="ripple-container"></div>
                                </button>-->


                                <div class="card">
                                    <div class="card-header card-header-icon logo-escola">
                                        <img src="../../conteudos/escola/<?php echo $pedido["arquivo"];?>" alt="">
                                    </div>
                                    <h4 class="card-title"><?php echo $pedido["nome_escola"];?></h4>
                                    <div class="card-content">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"><?php echo $pedido["codigo_pedido"];?></th>
                                                        <th><?php echo $pedido["nome_pedido"];?></th>
                                                        <th><?php echo $pedido["nivel_pedido"];?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">list</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Itens do Pedido</h4>
                                        <form method="POST" action="sessao_escola/adicionar_item_pedido.php">
                                            <div class="col-md-2 form-group label-floating">
                                                <label class="control-label">Referência</label>
                                                <input type="text" name="codigo_produto" class="form-control" required>
                                            </div>
                                            <div class="col-md-7 form-group label-floating">
                                                <input type="text" name="nome_produto" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-1 form-group label-floating">
                                                <input type="number" name="quantidade" class="form-control" required>
                                            </div>
                                            <div class="col-md-2 form-group label-floating">
                                                <input type="text" name="valor_produto" class="form-control" readonly>
                                            </div>
                                            <input type="hidden" name="codigo_pedido" id="codigo_pedido" value="<?php echo codifica($codigo_pedido);?>">
                                            <input type="hidden" name="acao" id="acao" value="<?php echo codifica("adicionar-item-item_pedido"); ?>">
                                            <button type="submit" class="btn btn-fill btn-success buscar"><span class="btn-label">
                                            <i class="material-icons">add</i>
                                            </span>Adicionar à item_pedido</button>
                                        </form>
                                    </div>
                                </div>


                                <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <h4 class="card-title">Produtos</h4>
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Código</th>
                                                    <th></th>
                                                    <th>Nome do produto</th>
                                                    <th>Quantidade</th>
                                                    <th>Valor Un.</th>
                                                    <th class="text-right">Valor Total R$</th>
                                                    <th class="text-right">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($itens AS $item_pedido):?>
                                                <tr>
                                                    <td class="text-center"><?php echo $item_pedido["referencia_produto"];?></td>
                                                    <td>
                                                        <div class="img-container">
                                                            <img src="/conteudos/produto/<?php echo $item_pedido["codigo_produto"];?>/<?php echo $item_pedido["arquivo_foto"];?>" alt="...">
                                                        </div>
                                                    </td>
                                                    <td><?php echo $item_pedido["nome_produto"];?></td>
                                                    <td><?php echo $item_pedido["quantidade"];?></td>
                                                    <td class="text-right">R$ <?php echo $item_pedido["valor_unitario"];?></td>
                                                    <td class="text-right">R$ <?php echo ($item_pedido["valor_unitario"]*$item_pedido["quantidade"]);?></td>
                                                    <td class="td-actions text-right" title="Remover item da item_pedido">
                                                        <button type="button" rel="tooltip" class="btn btn-danger" onclick="removerItem('<?php echo codifica($item_pedido["codigo_item_pedido"]);?>')">
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