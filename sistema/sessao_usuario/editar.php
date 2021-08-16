<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();
$codigo_usuario = protege(decodifica($_GET["codigo_usuario"]));
//consulta usuarios
$sql_consulta_usuario = "SELECT * FROM usuario WHERE usuario.codigo_usuario = '".$codigo_usuario."'";
$result = $pdo->query( $sql_consulta_usuario );
$usuario = $result->fetch( PDO::FETCH_ASSOC );


if(decodifica($_POST["acao"]) == "alterar"){
    
    $nome_usuario             = $_POST["nome_usuario"];
    $telefone_usuario         = $_POST["telefone_usuario"];
    $email_usuario            = $_POST["email_usuario"];
    
    if($_POST["senha_usuario"]):
        $senha_usuario            = md5($_POST["senha_usuario"]);
    else:
        $senha_usuario            = $usuario["senha_usuario"];
    endif;

    $situacao_usuario         = $_POST["situacao_usuario"];

    // Insere o usuario
    $usuarios = $pdo->prepare("UPDATE usuario SET
                            nome_usuario = :nome_usuario,
                            telefone_usuario = :telefone_usuario,
                            email_usuario =  :email_usuario,
                            senha_usuario =  :senha_usuario,
                            situacao_usuario = :situacao_usuario
                            WHERE codigo_usuario = :codigo_usuario");

    $usuarios->execute(array(
        ':codigo_usuario' => $codigo_usuario,
        ':nome_usuario' => $nome_usuario,
        ':telefone_usuario' => $telefone_usuario,
        ':email_usuario' => $email_usuario,
        ':senha_usuario' => $senha_usuario,
        ':situacao_usuario' => 'L'
    ));

    if(!$usuarios){
        $error_log[] = $usuarios->errorInfo();
    }
    
    if($error_log){
        redireciona("/sistema/sessao_usuario/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na alteração do usuario!")); 
    }else{
        redireciona("/sistema/sessao_usuario/consultar.php?me=".codifica(0,false)."&mm=".codifica("O usuario foi alterado com sucesso!")); 
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

                            <a href="sessao_usuario/consultar.php">
                            <button class="btn btn-info">
                                        <span class="btn-label">
                                        <i class="material-icons">reply</i>
                                        </span>
                                        VOLTAR
                                    <div class="ripple-container"></div>
                            </button>
                            </a>

                            
                            <div class="card">
                                <form method="post" action="sessao_usuario/editar.php?codigo_usuario=<?php echo codifica($codigo_usuario);?>" class="form-horizontal" multipart="" enctype="multipart/form-data">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">DADOS DO usuario</h4>
                                    </div>
                                    <div class="card-content">
                                        <?php $form = "editar";?>
                                        <?php require_once("form_usuario.php");?>
                                    </div>
                                    <input type="hidden" name="acao" id="acao" value="<?php echo codifica("alterar"); ?>">
                                    <button type="submit" class="btn btn-fill btn-rose salvar">Cadastrar usuario</button>
                                    
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