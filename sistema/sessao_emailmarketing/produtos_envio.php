<?php require_once("../sistema_mod_include.php");?>
<?php
    $msg_erro        = protege(decodifica($_GET["me"]));
    $mensagem        = protege(decodifica($_GET["mm"]));

    $codigo_emkt_envio        = protege(decodifica($_GET["codigo_emkt_envio"]));

    $referencia_produto        = protege($_POST["referencia_produto"]);
    $nome_produto        = protege($_POST["nome_produto"]);
    $fabricante        = protege($_POST["fabricante"]);
    $categoria        = protege($_POST["categoria"]);
    $subcategoria        = protege($_POST["subcategoria"]);

    if($referencia_produto):
        $sql_busca.= "AND produto.referencia_produto = '".$referencia_produto."' ";
    endif;

    if($nome_produto):
        $sql_busca.= "AND produto.nome_produto LIKE '%".$nome_produto."%' ";
    endif;

    if($fabricante):
        $sql_busca.= "AND produto.codigo_fabricante = '".$fabricante."' ";
    endif;

    if($categoria):
        $sql_busca.= "AND produto_categoria.codigo_categoria = '".$categoria."' ";
    endif;

    if($subcategoria):
        $sql_busca.= "AND produto_subcategoria.codigo_subcategoria = '".$subcategoria."' ";
    endif;

    

    //Abre a conexão
    $pdo = Database::conexao();
    //consulta produtos
    $sql_consulta_produtos_envio = "SELECT produto.codigo_produto, produto.nome_produto, produto.valor_produto, produto.estoque_produto, produto.situacao_produto, produto.referencia_produto, foto_produto.arquivo_foto
                                FROM produto
                                LEFT JOIN foto_produto ON foto_produto.codigo_produto = produto.codigo_produto
                                LEFT JOIN produto_categoria ON produto.codigo_produto = produto_categoria.codigo_produto
                                LEFT JOIN produto_subcategoria ON produto.codigo_produto = produto_subcategoria.codigo_produto
                                LEFT JOIN emkt_envio_produto ON produto.codigo_produto = emkt_envio_produto.codigo_produto
                                WHERE emkt_envio_produto.codigo_emkt_envio = '".$codigo_emkt_envio."' GROUP BY produto.codigo_produto ORDER BY produto.nome_produto ASC";
    $result = $pdo->query( $sql_consulta_produtos_envio );
	$total_produtos_envio = $result->rowCount();
    $produtos_envio = $result->fetchAll( PDO::FETCH_ASSOC );

    foreach($produtos_envio as $produto):
        $codigo_produtos_envio.= $produto["codigo_produto"].", ";
    endforeach;

    $codigo_produtos_envio.= "0";

    //print_r($codigo_produtos_envio); exit;

	//consulta produtos
    $sql_consulta_produto = "SELECT produto.codigo_produto, produto.nome_produto, produto.valor_produto, produto.estoque_produto, produto.situacao_produto, produto.referencia_produto, foto_produto.arquivo_foto
                                FROM produto
                                LEFT JOIN foto_produto ON foto_produto.codigo_produto = produto.codigo_produto
                                LEFT JOIN produto_categoria ON produto.codigo_produto = produto_categoria.codigo_produto
                                LEFT JOIN produto_subcategoria ON produto.codigo_produto = produto_subcategoria.codigo_produto
                                WHERE produto.situacao_produto <> 'E' ".$sql_busca." AND produto.codigo_produto NOT IN (".$codigo_produtos_envio.") GROUP BY produto.codigo_produto ORDER BY produto.nome_produto ASC LIMIT 30";
    $result = $pdo->query( $sql_consulta_produto );
	$total_produtos = $result->rowCount();
    $produtos = $result->fetchAll( PDO::FETCH_ASSOC );

    //consulta fabricantes
    $sql_consulta_fabricantes = "SELECT codigo_fabricante, nome_fabricante FROM fabricante WHERE status = 'L' ORDER BY nome_fabricante ASC";
    $result = $pdo->query( $sql_consulta_fabricantes );
    $fabricantes = $result->fetchAll( PDO::FETCH_ASSOC );

    //consulta categorias
    $sql_consulta_categorias = "SELECT codigo_categoria, nome_categoria FROM categoria WHERE status = 'L' ORDER BY nome_categoria ASC";
    $result = $pdo->query( $sql_consulta_categorias );
    $categorias = $result->fetchAll( PDO::FETCH_ASSOC );

    //consulta subcategorias
    $sql_consulta_subcategorias = "SELECT codigo_subcategoria, nome_subcategoria FROM subcategoria WHERE status = 'L' ORDER BY nome_subcategoria ASC";
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

        function confirmacao(id) {
           swal({
                    title: 'Deseja remover este item?',
                    text: 'Tenha certeza que deseja remover este produto, não haverá como restaurá-lo.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, pode excluir!',
                    cancelButtonText: 'Não, quero manter',
                    confirmButtonClass: "btn btn-success",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false
                }).then(function() {
                    window.location.href = "/sistema/sessao_produto/excluir.php?codigo_produto="+id;
                }, function(dismiss) {
                  // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                  if (dismiss === 'cancel') {
                    swal({
                      title: 'Operação cancelada',
                      text: 'Seu produto será mantido :)',
                      type: 'error',
                      confirmButtonClass: "btn btn-info",
                      buttonsStyling: false
                    })
                  }
                })
        }

        function adicionarProduto(id) {
           swal({
                    title: 'Deseja incluir este item?',
                    text: 'Clicando em confirmar o produto será incluído no envio do e-mail marketing.',
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, pode incluir!',
                    cancelButtonText: 'Não, este não!',
                    confirmButtonClass: "btn btn-success",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false
                }).then(function() {
                    window.location.href = "/sistema/sessao_emailmarketing/adicionar.php?acao=<?php echo codifica('adicionar-produto-envio');?>&codigo_produto="+id+"&codigo_envio=<?php echo codifica($codigo_emkt_envio);?>";
                }, function(dismiss) {
                  // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                  if (dismiss === 'cancel') {
                    swal({
                      title: 'Operação cancelada',
                      text: 'Selecione outro produto para enviar :)',
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

                            <a href="sessao_emailmarketing/consultar.php">
                                <button class="btn btn-info">
                                            <span class="btn-label">
                                            <i class="material-icons">reply</i>
                                            </span>
                                            VOLTAR
                                        <div class="ripple-container"></div>
                                </button>
                            </a>

                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <h4 class="card-title">Produtos definidos neste envio</h4>
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th></th>
                                                    <th>Nome do produto</th>
                                                    <th>Referência</th>
                                                    <th>Quantidade</th>
                                                    <th class="text-right">Valor R$</th>
                                                    <th class="text-right">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($produtos_envio AS $produto):?>
                                                <?php 
                                                    if($produto['arquivo_foto']){
                                                        $foto_produto = "https://www.realmat.com.br/conteudos/produto/".$produto['codigo_produto']."/".$produto['arquivo_foto'];   
                                                    }else{
                                                        $foto_produto = "https://www.realmat.com.br/conteudos/produto/produto-sem-foto.jpg"; 
                                                    }  
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $produto["codigo_produto"];?></td>
                                                    <td>
                                                        <div class="img-container">
                                                            <img src="<?php echo $foto_produto;?>" alt="...">
                                                        </div>
                                                    </td>
                                                    <td><?php echo $produto["nome_produto"];?></td>
                                                    <td><?php echo $produto["referencia_produto"];?></td>
                                                    <td><?php echo $produto["estoque_produto"];?></td>
                                                    <td class="text-right">R$ <?php echo $produto["valor_produto"];?></td>
                                                    <td class="td-actions text-right">
                                                        <button type="button" rel="tooltip" class="btn btn-danger" onclick="confirmacao('<?php echo codifica($produto["codigo_produto"]);?>')">
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

                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">mail_outline</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Busca Rápida</h4>
                                        <form method="POST" action="sessao_emailmarketing/produtos_envio.php?codigo_emkt_envio=<?php echo codifica($codigo_emkt_envio);?>">
                                            <div class="col-md-1 form-group label-floating">
                                                <label class="control-label">Referência</label>
                                                <input type="text" name="referencia_produto" class="form-control">
                                            </div>
                                            <div class="col-md-4 form-group label-floating">
                                                <label class="control-label">Nome do Produto</label>
                                                <input type="text" name="nome_produto" class="form-control">
                                            </div>
                                            <div class="col-md-2 form-group label-floating">
                                                <select class="selectpicker select-marca" name="fabricante" data-style="btn btn-primary btn-round" title="Single Select" data-size="7">
                                                    <option disabled selected>Marca</option>
                                                    <?php foreach($fabricantes as $fabricante): ?>
                                                        <option value="<?php echo $fabricante["codigo_fabricante"];?>"><?php echo $fabricante["nome_fabricante"];?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2 form-group label-floating">
                                                <select class="selectpicker select-marca" name="categoria" data-style="btn btn-primary btn-round" title="Single Select" data-size="7">
                                                    <option disabled selected>Categoria</option>
                                                    <?php foreach($categorias as $categoria): ?>
                                                        <option value="<?php echo $categoria["codigo_categoria"];?>"><?php echo $categoria["nome_categoria"];?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 form-group label-floating">
                                                <select class="selectpicker select-marca" name="subcategoria" data-style="btn btn-primary btn-round" title="Single Select" data-size="7">
                                                    <option disabled selected>Subcategoria</option>
                                                    <?php foreach($subcategorias as $subcategoria): ?>
                                                        <option value="<?php echo $subcategoria["codigo_subcategoria"];?>"><?php echo $subcategoria["nome_subcategoria"];?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-fill btn-rose buscar">Filtrar Produtos</button>
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
                                                    <th class="text-center">#</th>
                                                    <th></th>
                                                    <th>Nome do produto</th>
                                                    <th>Referência</th>
                                                    <th>Quantidade</th>
                                                    <th class="text-right">Valor R$</th>
                                                    <th class="text-right">Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($produtos AS $produto):?>

                                                <?php 
                                                    if($produto['arquivo_foto']){
                                                        $foto_produto = "https://www.realmat.com.br/conteudos/produto/".$produto['codigo_produto']."/".$produto['arquivo_foto'];   
                                                    }else{
                                                        $foto_produto = "https://www.realmat.com.br/conteudos/produto/produto-sem-foto.jpg"; 
                                                    }  
                                                ?>

                                                <tr>
                                                    <td class="text-center"><?php echo $produto["codigo_produto"];?></td>
                                                    <td>
                                                        <div class="img-container">
                                                            <img src="<?php echo $foto_produto;?>" alt="...">
                                                        </div>
                                                    </td>
                                                    <td><?php echo $produto["nome_produto"];?></td>
                                                    <td><?php echo $produto["referencia_produto"];?></td>
                                                    <td><?php echo $produto["estoque_produto"];?></td>
                                                    <td class="text-right">R$ <?php echo $produto["valor_produto"];?></td>
                                                    <td class="td-actions text-right">
                                                        <button type="button" rel="tooltip" class="btn btn-warning"  title="Adicionar Produto ao E-mail Marketing" onclick="adicionarProduto('<?php echo codifica($produto["codigo_produto"]);?>')">
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
            <footer class="footer">
                <?php include_once("../sistema_mod_footer.php");?>
            </footer>
        </div>
    </div>
    <?php require_once("../sistema_include_configuracoes.php"); ?>
</body>
<?php require_once("../sistema_include_js.php"); ?>

</html>