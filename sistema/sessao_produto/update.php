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
 
	$deleta_foto = $pdo->prepare("UPDATE foto_produto SET destaque_foto = 'S' WHERE codigo_foto = :codigo_foto");
    $deleta_foto->bindParam(':codigo_foto', $codigo_foto); 
    $deleta_foto->execute();

    if(!$deleta_foto){
        $error_log[] = $deleta_foto->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_produto/fotos_produto.php?codigo_produto=".codifica($produto["codigo_produto"])."&me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado!")); 
    }else{
        redireciona("/sistema/sessao_produto/fotos_produto.php?codigo_produto=".codifica($produto["codigo_produto"])."&me=".codifica(0,false)."&mm=".codifica("A foto foi definida como destaque!")); 
    }

}
?>