<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
$codigo_noticia = protege(decodifica($_GET["codigo_noticia"]));

//consulta noticias do produto
$sql_consulta_noticia = "SELECT codigo_noticia, titulo, resumo, arquivo, texto, status FROM noticia WHERE codigo_noticia = '".$codigo_noticia."'";
$result = $pdo->query( $sql_consulta_noticia );
$noticia = $result->fetch( PDO::FETCH_ASSOC );

if(decodifica($_POST["acao"]) == "alterar-noticia"){

    $codigo_noticia     = decodifica($_POST["codigo_noticia"]);
    $titulo             = $_POST["titulo"];
    $status             = $_POST["status"];
    $resumo             = $_POST["resumo"];
    $texto              = $_POST["texto"];

    $sql_consulta_noticia = "SELECT arquivo FROM noticia WHERE codigo_noticia = '".$codigo_noticia."'";
    $result = $pdo->query( $sql_consulta_noticia );
    $noticia = $result->fetch( PDO::FETCH_ASSOC );

    if(empty($_FILES['arquivo']['name'])):
        $filename = $noticia["arquivo"];
    else:        
        $diretorio = "../../conteudos/noticia/"; 
        $filename = $_FILES['arquivo']['name'];
        $ext = strrchr($filename, '.'); 
        $filename = time().uniqid().$ext;
        move_uploaded_file($_FILES["arquivo"]["tmp_name"],$diretorio . $filename);
    endif;

    // Insere o produto
    $altera_noticia = $pdo->prepare("UPDATE noticia SET
                            titulo = :titulo,
                            resumo = :resumo,
                            texto = :texto,
                            arquivo = :arquivo,
                            status = :status
                            WHERE codigo_noticia = :codigo_noticia");

    $altera_noticia->execute(array(
        ':codigo_noticia' => $codigo_noticia,
        ':titulo' => $titulo,
        ':resumo' => $resumo,
        ':texto' => $texto,
        ':arquivo' => $filename,
        ':status' => $status
    ));

    if(!$altera_noticia){
        $error_log[] = $altera_noticia->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_noticia/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração do noticia!")); 
    }else{
        redireciona("/sistema/sessao_noticia/consultar.php?me=".codifica(0,false)."&mm=".codifica("A noticia foi alterado com sucesso!")); 
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <?php include_once("../sistema_mod_head.php");?>
    <script type="text/javascript" src="assets/js/nicEdit-latest.js"></script>

    <script type="text/javascript">
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() }); // convert all text areas to rich text editor on that page

        bkLib.onDomLoaded(function() {
             new nicEditor().panelInstance('texto');
        }); // convert text area with id area1 to rich text editor.
        /*
        bkLib.onDomLoaded(function() {
             new nicEditor({fullPanel : true}).panelInstance('area2');
        }); // convert text area with id area2 to rich text editor with full panel.*/
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

                            <a href="sessao_noticia/consultar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">reply</i>
                                        </span>
                                        VOLTAR
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            <div class="card">
                                <form method="post" action="sessao_noticia/editar.php" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DA PUBLICAÇÃO</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-noticia"); ?>">
                                    <input type="hidden" name="codigo_noticia" id="codigo_noticia" value="<?php echo codifica($codigo_noticia); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Alterar noticia</button>
                                    
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