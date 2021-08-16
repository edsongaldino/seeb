<?php require_once("../sistema_mod_include.php");?>
<?php
    $codigo_usuario        = protege(decodifica($_GET["codigo_usuario"]));

    //Abre a conexão
    $pdo = Database::conexao();
   
	$deleta_usuario = $pdo->prepare('DELETE FROM usuario WHERE codigo_usuario = :codigo_usuario');
    $deleta_usuario->bindParam(':codigo_usuario', $codigo_usuario); 
    $deleta_usuario->execute();

    if(!$deleta_usuario){
        $error_log[] = $deleta_usuario->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_usuario/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir o usuario!")); 
    }else{
        redireciona("/sistema/sessao_usuario/consultar.php?me=".codifica(0,false)."&mm=".codifica("O usuario foi removido com sucesso!")); 
    }

?>