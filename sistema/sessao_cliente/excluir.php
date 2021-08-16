<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if($_GET["codigo_cliente"]){

    $codigo_cliente        = protege(decodifica($_GET["codigo_cliente"]));
 
	$deleta_cliente = $pdo->prepare('DELETE FROM cliente WHERE codigo_cliente = :codigo_cliente');
    $deleta_cliente->bindParam(':codigo_cliente', $codigo_cliente); 
    $deleta_cliente->execute();

    if(!$deleta_cliente){
        $error_log[] = $deleta_cliente->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_cliente/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir o cliente!")); 
    }else{
        redireciona("/sistema/sessao_cliente/consultar.php?me=".codifica(0,false)."&mm=".codifica("O cliente foi removido com sucesso!")); 
    }

}

?>