<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if(decodifica($_POST["acao"]) == "adicionar"){

    $referencia_produto         = $_POST["referencia_produto"];
    $nome_produto               = $_POST["nome_produto"];
    $valor_produto              = $_POST["valor_produto"];
    $estoque_produto            = $_POST["estoque_produto"];
    $resumo_produto             = $_POST["resumo_produto"];
    $descricao_produto          = $_POST["descricao_produto"];
    $destaque_produto           = $_POST["destaque_produto"];

    // Insere o produto
    $produtos = $pdo->prepare("INSERT INTO produto 
                            (referencia_produto, 
                            nome_produto, 
                            valor_produto, 
                            estoque_produto, 
                            resumo_produto, 
                            descricao_produto,
                            destaque_produto,
                            situacao_produto)
                            VALUES
                            (:referencia_produto, 
                            :nome_produto, 
                            :valor_produto, 
                            :estoque_produto, 
                            :resumo_produto,
                            :descricao_produto,
                            :destaque_produto,
                            :situacao_produto)");

    $produtos->execute(array(
        ':referencia_produto' => $referencia_produto,
        ':nome_produto' => $nome_produto,
        ':valor_produto' => $valor_produto,
        ':estoque_produto' => $estoque_produto,
        ':resumo_produto' => $resumo_produto,
        ':descricao_produto' => $descricao_produto,
        ':destaque_produto' => $destaque_produto,
        ':situacao_produto' => 'L'
    ));

    if(!$produtos){
        $error_log[] = $produtos->errorInfo();
    }

    $codigo_produto = $pdo->lastInsertId();

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

    $ftp_cria_pasta_raiz = mkdir("../../conteudos/produto/".$codigo_produto);
    $ftp_cria_pasta_mini = mkdir("../../conteudos/produto/".$codigo_produto."/mini");
    $ftp_cria_pasta_temp = mkdir("../../conteudos/produto/".$codigo_produto."/temp");
    $ftp_chmod_pasta_temp = chmod("../../conteudos/produto/".$codigo_produto."/temp", 0777);


    if ($ftp_cria_pasta_raiz && $ftp_cria_pasta_mini){
    
        $diretorio = "../../conteudos/produto/".$codigo_produto."/";        
        // Multiple file upload
        foreach($_FILES['fotos_produto']['name'] as $index=>$name){
            $filename = $name;
            if(!file_exists($diretorio.$filename)){
                move_uploaded_file($_FILES["fotos_produto"]["tmp_name"][$index],$diretorio . $filename);
                // Insere a foto do produto
                $subcategoria = $pdo->prepare("INSERT INTO foto_produto (codigo_produto, arquivo_foto, destaque_foto) VALUES (:codigo_produto, :arquivo_foto, :destaque_foto)");
                $subcategoria->execute(array(
                ':codigo_produto' => $codigo_produto,
                ':arquivo_foto' => $filename,
                ':destaque_foto' => 'N'
                ));

            }
        } 

    }

    if($error_log){
        redireciona("/sistema/sessao_produto/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na inclusão do produto!")); 
    }else{
        redireciona("/sistema/sessao_produto/consultar.php?me=".codifica(0,false)."&mm=".codifica("O produto foi adicionado com sucesso!")); 
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
                                <form method="post" action="sessao_produto/adicionar.php" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DO PRODUTO</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php $form = "adicionar";?>
                                        <?php require_once("form_produto.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("adicionar"); ?>">
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