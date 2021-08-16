<?php require_once("../sistema_mod_include.php");?>
<?php
    $codigo_pedido        = protege(decodifica($_GET["codigo_pedido"]));

    //Abre a conexão
    $pdo = Database::conexao();

    $deleta_vinculo_pedido = $pdo->prepare('DELETE FROM item_pedido WHERE codigo_pedido = :codigo_pedido');
    $deleta_vinculo_pedido->bindParam(':codigo_pedido', $codigo_pedido); 
    $deleta_vinculo_pedido->execute();
   
	$deleta_pedido = $pdo->prepare('DELETE FROM pedido WHERE codigo_pedido = :codigo_pedido');
    $deleta_pedido->bindParam(':codigo_pedido', $codigo_pedido); 
    $deleta_pedido->execute();

    if(!$deleta_pedido){
        $error_log[] = $deleta_pedido->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_pedido/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir o pedido!")); 
    }else{
        redireciona("/sistema/sessao_pedido/consultar.php?me=".codifica(0,false)."&mm=".codifica("O pedido foi removido com sucesso!")); 
    }

?>