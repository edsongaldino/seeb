<?php require_once("sistema_mod_include.php");?>
<?php
if(decodifica($_GET["acao"]) == "entrar"){
    $email        = protege($_GET["email"]);
    $senha        = protege($_GET["senha"]);

    //Abre a conexão
	$pdo = Database::conexao();
	//consulta usuário
    $sql_consulta_usuario = "SELECT * FROM usuario WHERE email_usuario = '".$email."' AND senha_usuario = '".md5($senha)."'";
    $result = $pdo->query( $sql_consulta_usuario );
	$total_usuarios = $result->rowCount();
    $usuario = $result->fetch( PDO::FETCH_ASSOC );

    if($usuario){

        // Insere o produto
        $produtos = $pdo->prepare("UPDATE usuario SET ultimo_acesso = :ultimo_acesso WHERE codigo_usuario = :codigo_usuario");
        $produtos->execute(array(
            ':ultimo_acesso' => date("YmdHis",time()),
            ':codigo_usuario' => $usuario['codigo_usuario']
        ));
        
        session_start();
        $_SESSION["codigo_usuario"] = $usuario['codigo_usuario'];
        $_SESSION["nome_usuario"] = $usuario['nome_usuario'];
        $_SESSION["email_usuario"] = $usuario['email_usuario'];

        $_SESSION["key_acesso"] = md5(KEY_SESSAO);
		$_SESSION["codigo_acesso"] = substr(md5(date("YmdHis", time()).str_shuffle("0123456789abcdefghijlmnopqrstuvxzwyk")),0,30);

        redireciona("/sistema/inicio.php?me=".codifica(0,false)."&mm=".codifica("Seja bem vindo ao sistema!")); 

    }else{
        redireciona("/sistema/index.php?me=".codifica(1,true)."&mm=".codifica("Ops, não foi possível fazer login!"));
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <?php include_once("sistema_mod_head.php");?>
</head>

<body>

    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="assets/img/login.jpeg">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <form method="GET" action="index.php">
                                <div class="card card-login card-hidden">
                                    <div class="card-header text-center" data-background-color="rose">
                                        <h4 class="card-title">Acesso Restrito</h4>
                                    </div>
                                    <p class="category text-center">
                                        Entre com seus dados de acesso
                                    </p>
                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Email</label>
                                                <input type="email" name="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Senha</label>
                                                <input type="password" name="senha" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer text-center">
                                        <input type="hidden" name="acao" class="form-control" value="<?php echo codifica("entrar");?>">
                                        <button type="submit" class="btn btn-rose btn-simple btn-wd btn-lg">ACESSAR</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container">
                    <p class="text-center">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="https://www.datapix.com.br">Datapix tecnologia</a>
                    </p>
                </div>
            </footer>
        </div>
    </div>
</body>
<div class="fixed-plugin">
    <div class="dropdown show-dropdown">
        <a href="#" data-toggle="dropdown">
            <i class="fa fa-cog fa-2x"> </i>
        </a>
        <ul class="dropdown-menu">
            <li class="header-title">Background Style</li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                    <p>Background Image</p>
                    <div class="togglebutton switch-sidebar-image">
                        <label>
                            <input type="checkbox" checked="">
                        </label>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger active-color">
                    <p>Filters</p>
                    <div class="badge-colors pull-right">
                        <span class="badge filter active" data-color="black"></span>
                        <span class="badge filter badge-blue" data-color="blue"></span>
                        <span class="badge filter badge-green" data-color="green"></span>
                        <span class="badge filter badge-orange" data-color="orange"></span>
                        <span class="badge filter badge-red" data-color="red"></span>
                        <span class="badge filter badge-purple" data-color="purple"></span>
                        <span class="badge filter badge-rose" data-color="rose"></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="header-title">Background Images</li>
            <li class="active">
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="assets/img/sidebar-1.jpg" data-src="assets/img/login.jpeg" alt="" />
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="assets/img/sidebar-2.jpg" data-src="assets/img/lock.jpeg" alt="" />
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="assets/img/sidebar-3.jpg" data-src="assets/img/header-doc.jpeg" alt="" />
                </a>
            </li>
            <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                    <img src="assets/img/sidebar-4.jpg" data-src="assets/img/bg-pricing.jpeg" alt="" />
                </a>
            </li>
            <li class="button-container">
                <div class="">
                    <a href="https://www.datapix.com.br" target="_blank" class="btn btn-primary btn-block btn-fill">Buy Now!</a>
                </div>
                <div class="">
                    <a href="https://www.datapix.com.br" target="_blank" class="btn btn-info btn-block">Get Free Demo</a>
                </div>
            </li>
            <li class="header-title">Thank you for 95 shares!</li>
            <li class="button-container">
                <button id="twitter" class="btn btn-social btn-twitter btn-round"><i class="fa fa-twitter"></i> &middot; 45</button>
                <button id="facebook" class="btn btn-social btn-facebook btn-round"><i class="fa fa-facebook-square"></i> &middot; 50</button>
            </li>
        </ul>
    </div>
</div>
</body>
<?php require_once("sistema_include_js.php"); ?>
<script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>

</html>