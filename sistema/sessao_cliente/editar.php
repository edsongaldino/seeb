<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
$codigo_cliente = protege(decodifica($_GET["codigo_cliente"]));

//consulta clientes do produto
$sql_consulta_cliente = "SELECT codigo_cliente, nome_cliente, arquivo, status FROM cliente WHERE codigo_cliente = '".$codigo_cliente."'";
$result = $pdo->query( $sql_consulta_cliente );
$cliente = $result->fetch( PDO::FETCH_ASSOC );

if(decodifica($_POST["acao"]) == "alterar-cliente"){

    $codigo_cliente = decodifica($_POST["codigo_cliente"]);
    $nome_cliente             = $_POST["nome_cliente"];
    $status               = $_POST["status"];

    if($_FILES['arquivo']['name']):
        $diretorio = "../../conteudos/cliente/"; 
        $filename = $_FILES['arquivo']['name'];
        $ext = strrchr($filename, '.'); 
        $filename = time().uniqid().$ext;
        move_uploaded_file($_FILES["arquivo"]["tmp_name"],$diretorio . $filename);
    else:        
        $filename = $cliente["arquivo"];
    
    endif;

    // Insere o produto
    $cliente = $pdo->prepare("UPDATE cliente SET
                            nome_cliente = :nome_cliente,
                            arquivo = :arquivo,
                            status = :status
                            WHERE codigo_cliente = :codigo_cliente");

    $cliente->execute(array(
        ':codigo_cliente' => $codigo_cliente,
        ':nome_cliente' => $nome_cliente,
        ':arquivo' => $filename,
        ':status' => $status
    ));

    if(!$cliente){
        $error_log[] = $cliente->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_cliente/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração da cliente!")); 
    }else{
        redireciona("/sistema/sessao_cliente/consultar.php?me=".codifica(0,false)."&mm=".codifica("A cliente foi alterada com sucesso!")); 
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

                            <a href="sessao_cliente/consultar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">reply</i>
                                        </span>
                                        VOLTAR
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            <div class="card">
                                <form method="post" action="sessao_cliente/editar.php?codigo_cliente=<?php echo codifica($codigo_cliente); ?>" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DA cliente</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-cliente"); ?>">
                                    <input type="hidden" name="codigo_cliente" id="codigo_cliente" value="<?php echo codifica($codigo_cliente); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Alterar cliente</button>
                                    
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