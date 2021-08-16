<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
$codigo_banner = protege(decodifica($_GET["codigo_banner"]));

//consulta banners do produto
$sql_consulta_banner = "SELECT codigo_banner, codigo_tipo_banner, titulo_banner, data_inicial, ordem_banner, descricao_banner, link_banner, data_final, arquivo, status FROM banner WHERE codigo_banner = '".$codigo_banner."'";
$result = $pdo->query( $sql_consulta_banner );
$banner = $result->fetch( PDO::FETCH_ASSOC );

if(decodifica($_POST["acao"]) == "alterar-banner"){

    $codigo_banner = decodifica($_POST["codigo_banner"]);
    $titulo_banner             = $_POST["titulo_banner"];
    $data_inicial              = $_POST["data_inicial"];
    $data_final                = $_POST["data_final"];
    $tipo                      = $_POST["tipo"];
    $status                    = $_POST["status"];
    $ordem_banner              = $_POST["ordem_banner"];
    $descricao_banner              = $_POST["descricao_banner"];
    $link_banner               = $_POST["link_banner"];

    if($_FILES['arquivo']['name']):
        $diretorio = "../../conteudos/banner/"; 
        $filename = $_FILES['arquivo']['name'];
        $ext = strrchr($filename, '.'); 
        $filename = time().uniqid().$ext;
        move_uploaded_file($_FILES["arquivo"]["tmp_name"],$diretorio . $filename);
    else:        
        $filename = $banner["arquivo"];
    endif;

    // Insere o produto
    $banner = $pdo->prepare("UPDATE banner SET
                            titulo_banner = :titulo_banner,
                            codigo_tipo_banner = :codigo_tipo_banner,
                            data_inicial = :data_inicial,
                            data_final = :data_final,
                            ordem_banner = :ordem_banner,
                            link_banner = :link_banner,
                            descricao_banner = :descricao_banner,
                            arquivo = :arquivo,
                            status = :status
                            WHERE codigo_banner = :codigo_banner");

    $banner->execute(array(
        ':codigo_banner' => $codigo_banner,
        ':codigo_tipo_banner' => $tipo,
        ':titulo_banner' => $titulo_banner,
        ':data_inicial' => $data_inicial,
        ':data_final' => $data_final,
        ':ordem_banner' => $ordem_banner,
        ':link_banner' => $link_banner,
        ':descricao_banner' => $descricao_banner,
        ':arquivo' => $filename,
        ':status' => $status
    ));

    if(!$banner){
        $error_log[] = $banner->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_banner/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração do banner!")); 
    }else{
        redireciona("/sistema/sessao_banner/consultar.php?me=".codifica(0,false)."&mm=".codifica("A banner foi alterado com sucesso!")); 
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

                            <a href="sessao_banner/consultar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">reply</i>
                                        </span>
                                        VOLTAR
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            <div class="card">
                                <form method="post" action="sessao_banner/editar.php?codigo_banner=<?php echo codifica($codigo_banner); ?>" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DO banner</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form_banner.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-banner"); ?>">
                                    <input type="hidden" name="codigo_banner" id="codigo_banner" value="<?php echo codifica($codigo_banner); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Alterar banner</button>
                                    
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