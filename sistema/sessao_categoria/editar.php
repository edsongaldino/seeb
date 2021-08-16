<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if($_GET["codigo_categoria"]):

$codigo_categoria = protege(decodifica($_GET["codigo_categoria"]));

//consulta categorias do produto
$sql_consulta_categoria = "SELECT codigo_categoria, nome_categoria, status FROM categoria WHERE codigo_categoria = '".$codigo_categoria."'";
$result = $pdo->query( $sql_consulta_categoria );
$categoria = $result->fetch( PDO::FETCH_ASSOC );

else:

$codigo_subcategoria = protege(decodifica($_GET["codigo_subcategoria"]));
//consulta categorias do produto
$sql_consulta_produto_subcategoria = "SELECT codigo_subcategoria, codigo_categoria, nome_subcategoria, status FROM subcategoria WHERE codigo_subcategoria = '".$codigo_subcategoria."'";
$result = $pdo->query( $sql_consulta_produto_subcategoria );
$subcategoria = $result->fetch( PDO::FETCH_ASSOC );

endif;



if(decodifica($_POST["acao"]) == "alterar-categoria"){

    $codigo_categoria           = decodifica($_POST["codigo_categoria"]);
    $nome_categoria             = $_POST["nome_categoria"];
    $status                     = $_POST["status"];

    // Insere o produto
    $categoria = $pdo->prepare("UPDATE categoria SET
                            nome_categoria = :nome_categoria,
                            status = :status
                            WHERE codigo_categoria = :codigo_categoria");

    $categoria->execute(array(
        ':codigo_categoria' => $codigo_categoria,
        ':nome_categoria' => $nome_categoria,
        ':status' => $status
    ));

    if(!$categoria){
        $error_log[] = $categoria->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_categoria/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração da categoria!")); 
    }else{
        redireciona("/sistema/sessao_categoria/consultar.php?me=".codifica(0,false)."&mm=".codifica("A categoria foi alterada com sucesso!")); 
    }
}

if(decodifica($_POST["acao"]) == "alterar-subcategoria"){

    $codigo_categoria           = $_POST["codigo_categoria"];
    $codigo_subcategoria        = decodifica($_POST["codigo_subcategoria"]);
    $nome_subcategoria          = $_POST["nome_subcategoria"];
    $status                     = $_POST["status"];

    // Insere o produto
    $subcategoria = $pdo->prepare("UPDATE subcategoria SET
                            codigo_categoria = :codigo_categoria,
                            nome_subcategoria = :nome_subcategoria,
                            status = :status
                            WHERE codigo_subcategoria = :codigo_subcategoria");
    $subcategoria->execute(array(
        ':codigo_categoria' => $codigo_categoria,
        ':codigo_subcategoria' => $codigo_subcategoria,
        ':nome_subcategoria' => $nome_subcategoria,
        ':status' => $status
    ));

    if(!$subcategoria){
        $error_log[] = $subcategoria->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_categoria/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração da subcategoria!")); 
    }else{
        redireciona("/sistema/sessao_categoria/consultar.php?me=".codifica(0,false)."&mm=".codifica("A subcategoria foi alterada com sucesso!")); 
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

                            <a href="sessao_categoria/consultar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">reply</i>
                                        </span>
                                        VOLTAR
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            <?php if($_GET["codigo_categoria"]):?>
                            <div class="card">
                                <form method="post" action="sessao_categoria/editar.php" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DA CATEGORIA</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form_categoria.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-categoria"); ?>">
                                    <input type="hidden" name="codigo_categoria" id="codigo_categoria" value="<?php echo codifica($codigo_categoria); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Alterar Categoria</button>
                                    
                                </form>
                            </div>
                            <?php else:?>
                            <div class="card">
                                <form method="post" action="sessao_categoria/editar.php" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DA SUBCATEGORIA</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form_subcategoria.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-subcategoria"); ?>">
                                    <input type="hidden" name="codigo_subcategoria" id="codigo_subcategoria" value="<?php echo codifica($codigo_subcategoria); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Alterar Subcategoria</button>
                                    
                                </form>
                            </div>
                            <?php endif;?>

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