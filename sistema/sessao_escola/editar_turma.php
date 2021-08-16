<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
$codigo_turma = protege(decodifica($_GET["codigo_turma"]));

//consulta turmas do produto
$sql_consulta_turma = "SELECT codigo_turma, codigo_escola, nivel_turma, nome_turma, status FROM turma WHERE codigo_turma = '".$codigo_turma."'";
$result = $pdo->query( $sql_consulta_turma );
$turma = $result->fetch( PDO::FETCH_ASSOC );

if(decodifica($_POST["acao"]) == "alterar-turma"){

    $codigo_turma = decodifica($_POST["codigo_turma"]);
    $codigo_escola         = $_POST["escola"];
    $nome_turma         = $_POST["nome_turma"];
    $nivel_turma         = $_POST["nivel_turma"];
    $status             = $_POST["status"];

    // Insere o produto
    $turma = $pdo->prepare("UPDATE turma SET
                            nome_turma = :nome_turma,
                            codigo_escola = :codigo_escola,
                            nivel_turma = :nivel_turma,
                            status = :status
                            WHERE codigo_turma = :codigo_turma");

    $turma->execute(array(
        ':codigo_turma' => $codigo_turma,
        ':nome_turma' => $nome_turma,
        ':nivel_turma' => $nivel_turma,
        ':codigo_escola' => $codigo_escola,
        ':status' => $status
    ));

    if(!$turma){
        $error_log[] = $turma->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_escola/turmas.php?codigo_escola=".codifica($codigo_escola)."&me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração da turma!")); 
    }else{
        redireciona("/sistema/sessao_escola/turmas.php?codigo_escola=".codifica($codigo_escola)."&me=".codifica(0,false)."&mm=".codifica("A turma foi alterada com sucesso!")); 
    }
}

//consulta escolas
$sql_consulta_escola = "SELECT escola.codigo_escola, escola.titulo_escola, escola.status FROM escola WHERE escola.status = 'L'";
$query_escola = $pdo->query( $sql_consulta_escola );
$escolas = $query_escola->fetchAll( PDO::FETCH_ASSOC );

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

                            <a href="sessao_turma/consultar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">reply</i>
                                        </span>
                                        VOLTAR
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            <div class="card">
                                <form method="post" action="sessao_escola/editar_turma.php?codigo_turma=<?php echo codifica($codigo_turma); ?>" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DA TURMA</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form_turma.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-turma"); ?>">
                                    <input type="hidden" name="codigo_turma" id="codigo_turma" value="<?php echo codifica($codigo_turma); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">ALTERAR TURMA</button>
                                    
                                </form>
                            </div>
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