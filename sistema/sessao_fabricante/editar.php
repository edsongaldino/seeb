<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
$codigo_fabricante = protege(decodifica($_GET["codigo_fabricante"]));

//consulta fabricantes do produto
$sql_consulta_fabricante = "SELECT codigo_fabricante, nome_fabricante, status FROM fabricante WHERE codigo_fabricante = '".$codigo_fabricante."'";
$result = $pdo->query( $sql_consulta_fabricante );
$fabricante = $result->fetch( PDO::FETCH_ASSOC );

if(decodifica($_POST["acao"]) == "alterar-fabricante"){

    $codigo_fabricante             = decodifica($_POST["codigo_fabricante"]);
    $nome_fabricante             = $_POST["nome_fabricante"];
    $status                     = $_POST["status"];

    // Insere o produto
    $fabricante = $pdo->prepare("UPDATE fabricante SET
                            nome_fabricante = :nome_fabricante,
                            status = :status
                            WHERE codigo_fabricante = :codigo_fabricante");

    $fabricante->execute(array(
        ':codigo_fabricante' => $codigo_fabricante,
        ':nome_fabricante' => $nome_fabricante,
        ':status' => $status
    ));

    if(!$fabricante){
        $error_log[] = $fabricante->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_fabricante/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração do fabricante!")); 
    }else{
        redireciona("/sistema/sessao_fabricante/consultar.php?me=".codifica(0,false)."&mm=".codifica("A fabricante foi alterado com sucesso!")); 
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

                            <a href="sessao_fabricante/consultar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">reply</i>
                                        </span>
                                        VOLTAR
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            <div class="card">
                                <form method="post" action="sessao_fabricante/editar.php" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DO FABRICANTE</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form_fabricante.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-fabricante"); ?>">
                                    <input type="hidden" name="codigo_fabricante" id="codigo_fabricante" value="<?php echo codifica($codigo_fabricante); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Alterar fabricante</button>
                                    
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