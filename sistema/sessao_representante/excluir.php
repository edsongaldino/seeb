<?php require_once("../sistema_mod_include.php");?>
<?php
    $codigo_produto        = protege(decodifica($_GET["codigo_produto"]));

    //Abre a conexão
    $pdo = Database::conexao();

    $deleta_fotos = $pdo->prepare('DELETE FROM foto_produto WHERE codigo_produto = :codigo_produto');
    $deleta_fotos->bindParam(':codigo_produto', $codigo_produto); 
    $deleta_fotos->execute();

    $deleta_vinculo_categoria = $pdo->prepare('DELETE FROM produto_categoria WHERE codigo_produto = :codigo_produto');
    $deleta_vinculo_categoria->bindParam(':codigo_produto', $codigo_produto); 
    $deleta_vinculo_categoria->execute();

    $deleta_vinculo_subcategoria = $pdo->prepare('DELETE FROM produto_subcategoria WHERE codigo_produto = :codigo_produto');
    $deleta_vinculo_subcategoria->bindParam(':codigo_produto', $codigo_produto); 
    $deleta_vinculo_subcategoria->execute();
   
	$deleta_produto = $pdo->prepare('DELETE FROM produto WHERE codigo_produto = :codigo_produto');
    $deleta_produto->bindParam(':codigo_produto', $codigo_produto); 
    $deleta_produto->execute();

    if(!$deleta_produto){
        $error_log[] = $deleta_produto->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_produto/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir o produto!")); 
    }else{
        redireciona("/sistema/sessao_produto/consultar.php?me=".codifica(0,false)."&mm=".codifica("O produto foi removido com sucesso!")); 
    }

?>