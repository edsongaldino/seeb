<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

$codigo_envio = protege(decodifica($_GET["codigo_envio"]));

//consulta envio
$sql_consulta_envio = "SELECT codigo_emkt_envio, titulo_emkt_envio, texto_emkt_envio, data_emkt_envio, status_emkt_envio, codigo_emkt_tipo_envio, imagem_emkt_envio, link_emkt_envio
FROM emkt_envio 
WHERE emkt_envio.codigo_emkt_envio = '".$codigo_envio."' ORDER BY emkt_envio.data_emkt_envio DESC";
$result = $pdo->query( $sql_consulta_envio );
$envio = $result->fetch( PDO::FETCH_ASSOC );


if(decodifica($_POST["acao"]) == "alterar-envio"){

    $codigo_emkt_envio = protege(decodifica($_POST["codigo_envio"]));
    $titulo_emkt_envio             = $_POST["titulo_envio"];
    $texto_emkt_envio             = $_POST["texto_envio"];
    $data_emkt_envio               = $_POST["data"];
    $codigo_emkt_tipo_envio        = $_POST["tipo"];
    $status_emkt_envio             = $_POST["status"];
    $link_emkt_envio               = $_POST["link_envio"];

    if($_FILES['arquivo']['name']):
        $diretorio = "../../conteudos/email_marketing/"; 
        $filename = $_FILES['arquivo']['name'];
        $ext = strrchr($filename, '.'); 
        $filename = time().uniqid().$ext;
        move_uploaded_file($_FILES["arquivo"]["tmp_name"],$diretorio . $filename);
    else:      
        $filename = decodifica($_POST["imagem_emkt_envio_antiga"]);
    endif;

    // Insere o produto
    $envio = $pdo->prepare("UPDATE emkt_envio SET
                            titulo_emkt_envio = :titulo_emkt_envio,
                            texto_emkt_envio = :texto_emkt_envio,
                            codigo_emkt_tipo_envio = :codigo_emkt_tipo_envio,
                            data_emkt_envio = :data_emkt_envio,
                            link_emkt_envio = :link_emkt_envio,
                            imagem_emkt_envio = :imagem_emkt_envio,
                            status_emkt_envio = :status_emkt_envio
                            WHERE codigo_emkt_envio = :codigo_emkt_envio");

    $envio->execute(array(
        ':codigo_emkt_envio' => $codigo_emkt_envio,
        ':titulo_emkt_envio' => $titulo_emkt_envio,
        ':texto_emkt_envio' => $texto_emkt_envio,
        ':codigo_emkt_tipo_envio' => $codigo_emkt_tipo_envio,
        ':data_emkt_envio' => $data_emkt_envio,
        ':link_emkt_envio' => $link_emkt_envio,
        ':imagem_emkt_envio' => $filename,
        ':status_emkt_envio' => $status_emkt_envio
    ));

    if(!$envio){
        $error_log[] = $envio->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_emailmarketing/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração do envio!")); 
    }else{
        redireciona("/sistema/sessao_emailmarketing/consultar.php?me=".codifica(0,false)."&mm=".codifica("O envio foi alterado com sucesso!")); 
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
                                <form method="post" action="sessao_emailmarketing/editar.php" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">INFORMAÇÕES DO ENVIO</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form_envio.php");?>
                                    </div>
                                    <input type="hidden" name="imagem_emkt_envio_antiga" id="imagem_emkt_envio_antiga" value="<?php echo codifica($envio["imagem_emkt_envio"]); ?>">
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-envio"); ?>">
                                    <input type="hidden" name="codigo_envio" id="codigo_envio" value="<?php echo codifica($codigo_envio); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Alterar Envio</button>
                                    
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