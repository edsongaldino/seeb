<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
$codigo_escola = protege(decodifica($_GET["codigo_escola"]));

//consulta escolas do produto
$sql_consulta_escola = "SELECT codigo_escola, titulo_escola, arquivo, status FROM escola WHERE codigo_escola = '".$codigo_escola."'";
$result = $pdo->query( $sql_consulta_escola );
$escola = $result->fetch( PDO::FETCH_ASSOC );

if(decodifica($_POST["acao"]) == "alterar-escola"){

    $codigo_escola = decodifica($_POST["codigo_escola"]);
    $titulo_escola             = $_POST["titulo_escola"];
    $status               = $_POST["status"];

    if($_FILES['arquivo']['name']):
        $diretorio = "../../conteudos/escola/"; 
        $filename = $_FILES['arquivo']['name'];
        $ext = strrchr($filename, '.'); 
        $filename = time().uniqid().$ext;
        move_uploaded_file($_FILES["arquivo"]["tmp_name"],$diretorio . $filename);
    else:        
        $filename = $escola["arquivo"];
    
    endif;

    // Insere o produto
    $escola = $pdo->prepare("UPDATE escola SET
                            titulo_escola = :titulo_escola,
                            arquivo = :arquivo,
                            status = :status
                            WHERE codigo_escola = :codigo_escola");

    $escola->execute(array(
        ':codigo_escola' => $codigo_escola,
        ':titulo_escola' => $titulo_escola,
        ':arquivo' => $filename,
        ':status' => $status
    ));

    if(!$escola){
        $error_log[] = $escola->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_escola/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração da escola!")); 
    }else{
        redireciona("/sistema/sessao_escola/consultar.php?me=".codifica(0,false)."&mm=".codifica("A escola foi alterada com sucesso!")); 
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

                            <a href="sessao_escola/consultar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">reply</i>
                                        </span>
                                        VOLTAR
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            <div class="card">
                                <form method="post" action="sessao_escola/editar.php?codigo_escola=<?php echo codifica($codigo_escola); ?>" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DA ESCOLA</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-escola"); ?>">
                                    <input type="hidden" name="codigo_escola" id="codigo_escola" value="<?php echo codifica($codigo_escola); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Alterar escola</button>
                                    
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