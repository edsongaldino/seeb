<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
$codigo_texto = protege(decodifica($_GET["codigo_texto"]));

//consulta textos do produto
$sql_consulta_texto = "SELECT codigo_texto, titulo, subtitulo, arquivo, texto, sessao, status FROM texto WHERE codigo_texto = '".$codigo_texto."'";
$result = $pdo->query( $sql_consulta_texto );
$texto = $result->fetch( PDO::FETCH_ASSOC );

if(decodifica($_POST["acao"]) == "alterar-texto"){

    $codigo_texto    = decodifica($_POST["codigo_texto"]);
    $titulo          = $_POST["titulo"];
    $status          = $_POST["status"];
    $subtitulo       = $_POST["subtitulo"];
    $texto_completo  = $_POST["texto"];
    $sessao  = $_POST["sessao"];

    $sql_consulta_texto = "SELECT arquivo FROM texto WHERE codigo_texto = '".$codigo_texto."'";
    $result = $pdo->query( $sql_consulta_texto );
    $texto = $result->fetch( PDO::FETCH_ASSOC );

    if(empty($_FILES['arquivo']['name'])):
        $filename = $texto["arquivo"];
    else:        
        $diretorio = "../../conteudos/texto/"; 
        $filename = $_FILES['arquivo']['name'];
        $ext = strrchr($filename, '.'); 
        $filename = time().uniqid().$ext;
        move_uploaded_file($_FILES["arquivo"]["tmp_name"],$diretorio . $filename);
    endif;

    // Insere o produto
    $altera_texto = $pdo->prepare("UPDATE texto SET
                            titulo = :titulo,
                            subtitulo = :subtitulo,
                            texto = :texto,
                            arquivo = :arquivo,
                            sessao = :sessao,
                            status = :status
                            WHERE codigo_texto = :codigo_texto");

    $altera_texto->execute(array(
        ':codigo_texto' => $codigo_texto,
        ':titulo' => $titulo,
        ':subtitulo' => $subtitulo,
        ':texto' => $texto_completo,
        ':arquivo' => $filename,
        ':sessao' => $sessao,
        ':status' => $status
    ));

    if(!$altera_texto){
        $error_log[] = $altera_texto->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_texto/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração do texto!")); 
    }else{
        redireciona("/sistema/sessao_texto/consultar.php?me=".codifica(0,false)."&mm=".codifica("A texto foi alterado com sucesso!")); 
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
             new nicEditor().panelInstance('texto_completo');
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

                            <a href="sessao_texto/consultar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">reply</i>
                                        </span>
                                        VOLTAR
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            <div class="card">
                                <form method="post" action="sessao_texto/editar.php" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">INFORMAÇÕES</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form_texto.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-texto"); ?>">
                                    <input type="hidden" name="codigo_texto" id="codigo_texto" value="<?php echo codifica($codigo_texto); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Alterar texto</button>
                                    
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