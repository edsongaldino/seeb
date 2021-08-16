<?php require_once("../sistema_mod_include.php");?>
<?php

 //Abre a conexão
 $pdo = Database::conexao();

if($_GET["codigo_foto"]){

    $codigo_foto = protege(decodifica($_GET["codigo_foto"]));

    //consulta produtos
    $sql_consulta_produto = "SELECT codigo_produto FROM foto_produto WHERE foto_produto.codigo_foto = '".$codigo_foto."'";
    $result = $pdo->query( $sql_consulta_produto );
    $produto = $result->fetch( PDO::FETCH_ASSOC );
 
	$deleta_foto = $pdo->prepare('DELETE FROM foto_produto WHERE codigo_foto = :codigo_foto');
    $deleta_foto->bindParam(':codigo_foto', $codigo_foto); 
    $deleta_foto->execute();

    if(!$deleta_foto){
        $error_log[] = $deleta_foto->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_produto/fotos_produto.php?codigo_produto=".codifica($produto["codigo_produto"])."&me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir a categoria!")); 
    }else{
        redireciona("/sistema/sessao_produto/fotos_produto.php?codigo_produto=".codifica($produto["codigo_produto"])."&me=".codifica(0,false)."&mm=".codifica("A categoria foi removida com sucesso!")); 
    }

}

if($_GET["codigo_produto"]){

    $codigo_produto        = protege(decodifica($_GET["codigo_produto"]));

   

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

}
?>