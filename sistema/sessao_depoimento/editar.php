<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
$codigo_depoimento = protege(decodifica($_GET["codigo_depoimento"]));

//consulta depoimentos do produto
$sql_consulta_depoimento = "SELECT codigo_depoimento, titulo, subtitulo, arquivo, estrelas, depoimento, status FROM depoimento WHERE codigo_depoimento = '".$codigo_depoimento."'";
$result = $pdo->query( $sql_consulta_depoimento );
$depoimento = $result->fetch( PDO::FETCH_ASSOC );

if(decodifica($_POST["acao"]) == "alterar-depoimento"){

    $codigo_depoimento    = decodifica($_POST["codigo_depoimento"]);
    $titulo          = $_POST["titulo"];
    $status          = $_POST["status"];
    $subtitulo       = $_POST["subtitulo"];
    $depoimento_completo  = $_POST["depoimento"];
    $estrelas  = $_POST["estrelas"];

    $sql_consulta_depoimento = "SELECT arquivo FROM depoimento WHERE codigo_depoimento = '".$codigo_depoimento."'";
    $result = $pdo->query( $sql_consulta_depoimento );
    $depoimento = $result->fetch( PDO::FETCH_ASSOC );

    if(empty($_FILES['arquivo']['name'])):
        $filename = $depoimento["arquivo"];
    else:        
        $diretorio = "../../conteudos/depoimento/"; 
        $filename = $_FILES['arquivo']['name'];
        $ext = strrchr($filename, '.'); 
        $filename = time().uniqid().$ext;
        move_uploaded_file($_FILES["arquivo"]["tmp_name"],$diretorio . $filename);
    endif;

    // Insere o produto
    $altera_depoimento = $pdo->prepare("UPDATE depoimento SET
                            titulo = :titulo,
                            subtitulo = :subtitulo,
                            depoimento = :depoimento,
                            arquivo = :arquivo,
                            estrelas = :estrelas,
                            status = :status
                            WHERE codigo_depoimento = :codigo_depoimento");

    $altera_depoimento->execute(array(
        ':codigo_depoimento' => $codigo_depoimento,
        ':titulo' => $titulo,
        ':subtitulo' => $subtitulo,
        ':depoimento' => $depoimento_completo,
        ':arquivo' => $filename,
        ':estrelas' => $estrelas,
        ':status' => $status
    ));

    if(!$altera_depoimento){
        $error_log[] = $altera_depoimento->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_depoimento/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração do depoimento!")); 
    }else{
        redireciona("/sistema/sessao_depoimento/consultar.php?me=".codifica(0,false)."&mm=".codifica("A depoimento foi alterado com sucesso!")); 
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
             new nicEditor().panelInstance('depoimento_completo');
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

                            <a href="sessao_depoimento/consultar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">reply</i>
                                        </span>
                                        VOLTAR
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            <div class="card">
                                <form method="post" action="sessao_depoimento/editar.php" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">INFORMAÇÕES</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-depoimento"); ?>">
                                    <input type="hidden" name="codigo_depoimento" id="codigo_depoimento" value="<?php echo codifica($codigo_depoimento); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Alterar depoimento</button>
                                    
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