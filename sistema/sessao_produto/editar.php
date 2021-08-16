<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
$codigo_produto = protege(decodifica($_GET["codigo_produto"]));
//consulta produtos
$sql_consulta_produto = "SELECT * FROM produto WHERE produto.codigo_produto = '".$codigo_produto."'";
$result = $pdo->query( $sql_consulta_produto );
$produto = $result->fetch( PDO::FETCH_ASSOC );

//consulta linhas do produto
/*
$sql_consulta_produto_linhas = "SELECT codigo_linha FROM produto_linha WHERE codigo_produto = '".$codigo_produto."'";
$result = $pdo->query( $sql_consulta_produto_linhas );
$linhas = $result->fetchAll( PDO::FETCH_ASSOC );
foreach($linhas as $linha_produto){$produto_linha[] = $linha_produto["codigo_linha"];}*/

//consulta categorias do produto
$sql_consulta_produto_categorias = "SELECT codigo_categoria FROM produto_categoria WHERE codigo_produto = '".$codigo_produto."'";
$result = $pdo->query( $sql_consulta_produto_categorias );
$categorias = $result->fetchAll( PDO::FETCH_ASSOC );
foreach($categorias as $categoria_produto){$produto_categoria[] = $categoria_produto["codigo_categoria"];}

//consulta categorias do produto
$sql_consulta_produto_subcategorias = "SELECT codigo_subcategoria FROM produto_subcategoria WHERE codigo_produto = '".$codigo_produto."'";
$result = $pdo->query( $sql_consulta_produto_subcategorias );
$subcategorias = $result->fetchAll( PDO::FETCH_ASSOC );
foreach($subcategorias as $subcategoria_produto){$produto_subcategoria[] = $subcategoria_produto["codigo_subcategoria"];}

if(decodifica($_POST["acao"]) == "alterar"){

    $referencia_produto         = $_POST["referencia_produto"];
    $codigo_fabricante          = $_POST["fabricante"];
    $nome_produto               = $_POST["nome_produto"];
    $valor_produto              = $_POST["valor_produto"];
    $estoque_produto            = $_POST["estoque_produto"];
    $resumo_produto             = $_POST["resumo_produto"];
    $descricao_produto          = $_POST["descricao_produto"];
    $destaque_produto           = $_POST["destaque_produto"];
    $situacao_produto           = $_POST["situacao_produto"];
    $oferta_produto             = $_POST["oferta_produto"];


    // Insere o produto
    $produtos = $pdo->prepare("UPDATE produto SET
                            codigo_fabricante = :codigo_fabricante,
                            referencia_produto = :referencia_produto,
                            nome_produto = :nome_produto,
                            valor_produto = :valor_produto,
                            estoque_produto =  :estoque_produto,
                            resumo_produto = :resumo_produto,
                            descricao_produto = :descricao_produto,
                            destaque_produto = :destaque_produto,
                            oferta_produto = :oferta_produto,
                            situacao_produto = :situacao_produto
                            WHERE codigo_produto = :codigo_produto");

    $produtos->execute(array(
        ':codigo_produto' => $codigo_produto,
        ':codigo_fabricante' => $codigo_fabricante,
        ':referencia_produto' => $referencia_produto,
        ':nome_produto' => $nome_produto,
        ':valor_produto' => converte_valor_mysql($valor_produto),
        ':estoque_produto' => $estoque_produto,
        ':resumo_produto' => $resumo_produto,
        ':descricao_produto' => $descricao_produto,
        ':destaque_produto' => $destaque_produto,
        ':oferta_produto' => $oferta_produto,
        ':situacao_produto' => 'L'
    ));

    if(!$produtos){
        $error_log[] = $produtos->errorInfo();
    }


    // Insere o produto na categoria
    $deleta_categoria = $pdo->prepare("DELETE FROM produto_categoria WHERE codigo_produto = :codigo_produto");
    $deleta_categoria->execute(array(
    ':codigo_produto' => $codigo_produto
    ));

    for($i=0;$i<count($_POST['categoria_produto']);$i++){

        // Insere o produto na categoria
        $categoria = $pdo->prepare("INSERT INTO produto_categoria (codigo_produto, codigo_categoria) VALUES (:codigo_produto, :codigo_categoria)");
        $categoria->execute(array(
        ':codigo_produto' => $codigo_produto,
        ':codigo_categoria' => $_POST['categoria_produto'][$i]
        ));

        if(!$categoria){
            $error_log[] = $categoria->errorInfo();
        }

    }
    
    // Insere o produto na categoria
    $deleta_subcategoria = $pdo->prepare("DELETE FROM produto_subcategoria WHERE codigo_produto = :codigo_produto");
    $deleta_subcategoria->execute(array(
    ':codigo_produto' => $codigo_produto
    ));
	
    for($i=0;$i<count($_POST['subcategoria_produto']);$i++){
        
        // Insere o produto na categoria
        $subcategoria = $pdo->prepare("INSERT INTO produto_subcategoria (codigo_produto, codigo_subcategoria) VALUES (:codigo_produto, :codigo_subcategoria)");
        $subcategoria->execute(array(
        ':codigo_produto' => $codigo_produto,
        ':codigo_subcategoria' => $_POST['subcategoria_produto'][$i]
        ));

        if(!$subcategoria){
            $error_log[] = $subcategoria->errorInfo();
        }

    }

    if($error_log){
        redireciona("/sistema/sessao_produto/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração do produto!")); 
    }else{
        redireciona("/sistema/sessao_produto/consultar.php?me=".codifica(0,false)."&mm=".codifica("O produto foi alterado com sucesso!")); 
    }
}

?>
<!doctype html>
<html lang="pt-br">
<head>
    <?php include_once("../sistema_mod_head.php");?>
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

                            <a href="sessao_produto/consultar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">reply</i>
                                        </span>
                                        VOLTAR
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            
                            <div class="card">
                                <form method="post" action="sessao_produto/editar.php?codigo_produto=<?php echo codifica($codigo_produto);?>" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DO PRODUTO</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php $form = "editar";?>
                                        <?php require_once("form_produto.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar"); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Cadastrar Produto</button>
                                    
                                </form>
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
    <?php include_once("../sistema_include_configuracoes.php"); ?>
</body>
<?php include_once("../sistema_include_js.php"); ?>
</html>