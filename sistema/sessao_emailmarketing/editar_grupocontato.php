<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if($_GET["codigo_emkt_contato"]):

$codigo_emkt_contato = protege(decodifica($_GET["codigo_emkt_contato"]));

//consulta contatos
$sql_consulta_contatos = "SELECT codigo_emkt_contato, nome_emkt_contato, email_emkt_contato, status_emkt_contato FROM emkt_contato WHERE codigo_emkt_contato = '".$codigo_emkt_contato."'";
$result = $pdo->query( $sql_consulta_contatos );
$contato = $result->fetch( PDO::FETCH_ASSOC );

$sql_consulta_grupo_contato = "SELECT codigo_emkt_grupo FROM emkt_grupo_contato WHERE codigo_emkt_contato = '".$codigo_emkt_contato."'";
$result = $pdo->query( $sql_consulta_grupo_contato );
$grupos = $result->fetchAll( PDO::FETCH_ASSOC );
foreach($grupos as $grupo_contato){$grupos_contato[] = $grupo_contato["codigo_emkt_grupo"];}

else:

$codigo_grupo = protege(decodifica($_GET["codigo_grupo"]));

//consulta grupos
$sql_consulta_grupos = "SELECT codigo_emkt_grupo, titulo_emkt_grupo, status_emkt_grupo FROM emkt_grupo WHERE codigo_emkt_grupo = '".$codigo_grupo."'";
$result = $pdo->query( $sql_consulta_grupos );
$grupo = $result->fetch( PDO::FETCH_ASSOC );

endif;



if(decodifica($_POST["acao"]) == "alterar-grupo"){

    $codigo_emkt_grupo           = decodifica($_POST["codigo_grupo"]);
    $titulo_emkt_grupo           = $_POST["titulo_emkt_grupo"];
    $status_emkt_grupo           = $_POST["status_emkt_grupo"];

    // Insere o produto
    $emkt_grupo = $pdo->prepare("UPDATE emkt_grupo SET
                            titulo_emkt_grupo = :titulo_emkt_grupo,
                            status_emkt_grupo = :status_emkt_grupo
                            WHERE codigo_emkt_grupo = :codigo_emkt_grupo");

    $emkt_grupo->execute(array(
        ':codigo_emkt_grupo' => $codigo_emkt_grupo,
        ':titulo_emkt_grupo' => $titulo_emkt_grupo,
        ':status_emkt_grupo' => $status_emkt_grupo
    ));

    if(!$emkt_grupo){
        $error_log[] = $emkt_grupo->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_emailmarketing/grupos_contatos.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração do grupo!")); 
    }else{
        redireciona("/sistema/sessao_emailmarketing/grupos_contatos.php?me=".codifica(0,false)."&mm=".codifica("O grupo foi alterado com sucesso!")); 
    }
}

if(decodifica($_POST["acao"]) == "alterar-contato"){


    $codigo_emkt_contato             = decodifica($_POST["codigo_emkt_contato"]);
    $nome_emkt_contato               = $_POST["nome_emkt_contato"];
    $email_emkt_contato              = $_POST["email_emkt_contato"];
    $status_emkt_contato             = $_POST["status"];

    // Insere o produto
    $contato = $pdo->prepare("UPDATE emkt_contato SET
                            nome_emkt_contato = :nome_emkt_contato,
                            email_emkt_contato = :email_emkt_contato,
                            status_emkt_contato = :status_emkt_contato
                            WHERE codigo_emkt_contato = :codigo_emkt_contato");
    $contato->execute(array(
        ':nome_emkt_contato' => $nome_emkt_contato,
        ':email_emkt_contato' => $email_emkt_contato,
        ':status_emkt_contato' => $status_emkt_contato,
        ':codigo_emkt_contato' => $codigo_emkt_contato
    ));

    if(!$contato){
        $error_log[] = $contato->errorInfo();
    }

    // Deleta vínculos
    $deleta_grupo = $pdo->prepare("DELETE FROM emkt_grupo_contato WHERE codigo_emkt_contato = :codigo_emkt_contato");
    $deleta_grupo->execute(array(
    ':codigo_emkt_contato' => $codigo_emkt_contato
    ));

    for($i=0;$i<count($_POST['grupo']);$i++){

        // Insere o produto na categoria
        $grupo = $pdo->prepare("INSERT INTO emkt_grupo_contato (codigo_emkt_contato, codigo_emkt_grupo) VALUES (:codigo_emkt_contato, :codigo_emkt_grupo)");
        $grupo->execute(array(
        ':codigo_emkt_contato' => $codigo_emkt_contato,
        ':codigo_emkt_grupo' => $_POST['grupo'][$i]
        ));

        if(!$grupo){
            $error_log[] = $grupo->errorInfo();
        }

    }

    if($error_log){
        redireciona("/sistema/sessao_emailmarketing/grupos_contatos.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração do contato!")); 
    }else{
        redireciona("/sistema/sessao_emailmarketing/grupos_contatos.php?me=".codifica(0,false)."&mm=".codifica("O contato foi alterado com sucesso!")); 
    }
}

//consulta grupos
$sql_consulta_grupos = "SELECT codigo_emkt_grupo, titulo_emkt_grupo, status_emkt_grupo FROM emkt_grupo ORDER BY titulo_emkt_grupo ASC";
$result = $pdo->query( $sql_consulta_grupos );
$grupos = $result->fetchAll( PDO::FETCH_ASSOC );

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

                            <?php if($_GET["codigo_grupo"]):?>
                            <div class="card">
                                <form method="post" action="sessao_emailmarketing/editar_grupocontato.php" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DO GRUPO</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form_grupo.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-grupo"); ?>">
                                    <input type="hidden" name="codigo_grupo" id="codigo_grupo" value="<?php echo codifica($codigo_grupo); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Alterar Grupo</button>
                                    
                                </form>
                            </div>
                            <?php else:?>
                            <div class="card">
                                <form method="post" action="sessao_emailmarketing/editar_grupocontato.php" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DO CONTATO</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php require_once("form_contato.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar-contato"); ?>">
                                    <input type="hidden" name="codigo_emkt_contato" id="codigo_emkt_contato" value="<?php echo codifica($codigo_emkt_contato); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Alterar Contato</button>
                                    
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