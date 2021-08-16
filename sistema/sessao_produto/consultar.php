<?php require_once("../sistema_mod_include.php");?>
<?php
    $msg_erro        = protege(decodifica($_GET["me"]));
    $mensagem        = protege(decodifica($_GET["mm"]));

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


    /* Constantes de configuração */  
    define('QTDE_REGISTROS', 20);   
    define('RANGE_PAGINAS', 3);   
    
    /* Recebe o número da página via parâmetro na URL */  
    $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;   
    
    /* Calcula a linha inicial da consulta */  
    $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;


    //Abre a conexão
    $pdo = Database::conexao();
    

    //consulta produtos
    $sql_consulta_produto_total = "SELECT produto.codigo_produto, produto.nome_produto, produto.valor_produto, produto.estoque_produto, produto.situacao_produto, produto.referencia_produto, foto_produto.arquivo_foto
    FROM produto
    LEFT JOIN foto_produto ON foto_produto.codigo_produto = produto.codigo_produto
    LEFT JOIN produto_categoria ON produto.codigo_produto = produto_categoria.codigo_produto
    LEFT JOIN produto_subcategoria ON produto.codigo_produto = produto_subcategoria.codigo_produto
    WHERE produto.situacao_produto <> 'E' ".$sql_busca." GROUP BY produto.codigo_produto ORDER BY produto.nome_produto ASC";
    $result = $pdo->query( $sql_consulta_produto_total );
    $total_produtos = $result->rowCount();
    
	//consulta produtos
    $sql_consulta_produto = "SELECT produto.codigo_produto, produto.nome_produto, produto.valor_produto, produto.estoque_produto, produto.situacao_produto, produto.referencia_produto, foto_produto.arquivo_foto
                                FROM produto
                                LEFT JOIN foto_produto ON foto_produto.codigo_produto = produto.codigo_produto
                                LEFT JOIN produto_categoria ON produto.codigo_produto = produto_categoria.codigo_produto
                                LEFT JOIN produto_subcategoria ON produto.codigo_produto = produto_subcategoria.codigo_produto
                                WHERE produto.situacao_produto <> 'E' ".$sql_busca." GROUP BY produto.codigo_produto ORDER BY produto.nome_produto ASC LIMIT ".$linha_inicial.",".QTDE_REGISTROS;
    $result = $pdo->query( $sql_consulta_produto );
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

    /* Idêntifica a primeira página */  
    $primeira_pagina = 1;   
    
    /* Cálcula qual será a última página */  
    $ultima_pagina  = ceil($total_produtos / QTDE_REGISTROS);   
    
    /* Cálcula qual será a página anterior em relação a página atual em exibição */   
    $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 :  
    
    /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */   
    $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 :   
    
    /* Cálcula qual será a página inicial do nosso range */    
    $range_inicial  = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1 ;   
    
    /* Cálcula qual será a página final do nosso range */    
    $range_final   = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina ;   
    
    /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */   
    $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder'; 
    
    /* Verifica se vai exibir o botão "Anterior" e "Último" */   
    $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder'; 

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

                            <a href="sessao_produto/adicionar.php">
                                <button class="btn btn-info">
                                            <span class="btn-label">
                                            <i class="material-icons">add</i>
                                            </span>
                                            ADICIONAR PRODUTO
                                        <div class="ripple-container"></div>
                                </button>
                            </a>

                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="rose">
                                        <i class="material-icons">mail_outline</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Busca Rápida</h4>
                                        <form method="POST" action="sessao_produto/consultar.php">
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
                                                        $foto_produto = "../conteudos/produto/".$produto['codigo_produto']."/".$produto['arquivo_foto'];   
                                                    }else{
                                                        $foto_produto = "../conteudos/produto/produto-sem-foto.jpg"; 
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
                                                        <button type="button" rel="tooltip" class="btn btn-info" onclick="window.open('sessao_produto/fotos_produto.php?codigo_produto=<?php echo codifica($produto["codigo_produto"]);?>', '_self')">
                                                            <i class="material-icons">camera_enhance</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" class="btn btn-success" onclick="window.open('sessao_produto/editar.php?codigo_produto=<?php echo codifica($produto["codigo_produto"]);?>', '_self')">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" class="btn btn-danger" onclick="confirmacao('<?php echo codifica($produto["codigo_produto"]);?>')">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                                
                                            </tbody>

                                        </table>

                                        <div class='box-paginacao'>
                                            <?php if($total_produtos>0):?>     
                                            <a class='box-navegacao <?=$exibir_botao_inicio?>' href="sessao_produto/consultar.php?<?=$url_busca?>page=<?=$primeira_pagina?>" title="Primeira Página">Primeira</a>    
                                            <!--<a class='box-navegacao <?=$exibir_botao_inicio?>' href="sessao_produto/consultar.php?<?=$url_busca?>page=<?=$pagina_anterior?>" title="Página Anterior">Anterior</a>-->   
                                        
                                            <?php  
                                            /* Loop para montar a páginação central com os números */   
                                            for ($i=$range_inicial; $i <= $range_final; $i++):   
                                            $destaque = ($i == $pagina_atual) ? 'destaque' : '' ;  
                                            ?>
                                            <?php if($i<>null):?>  
                                            <a class='box-numero <?=$destaque?>' href="sessao_produto/consultar.php?<?=$url_busca?>page=<?=$i?>"><?=$i?></a>
                                            <?php endif; ?> 
                                            <?php endfor; ?>    
                                        
                                            <!--<a class='box-navegacao <?=$exibir_botao_final?>' href="sessao_produto/consultar.php?<?=$url_busca?>page=<?php echo $proxima_pagina;?>" title="Próxima Página">Próxima</a>-->   
                                            <a class='box-navegacao <?=$exibir_botao_final?>' href="sessao_produto/consultar.php?<?=$url_busca?>page=<?=$ultima_pagina?>" title="Última Página">Última >></a>    
                                            </div>   
                                            <?php else: ?>   
                                            <p class="bg-danger">Nenhum registro foi encontrado!</p>  
                                            <?php endif; ?>   
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