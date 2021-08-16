<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if($_GET["codigo_categoria"]){

    $codigo_categoria        = protege(decodifica($_GET["codigo_categoria"]));

    $deleta_vinculo_categoria = $pdo->prepare('DELETE FROM produto_categoria WHERE codigo_categoria = :codigo_categoria');
    $deleta_vinculo_categoria->bindParam(':codigo_categoria', $codigo_categoria); 
    $deleta_vinculo_categoria->execute();
  
	$deleta_categoria = $pdo->prepare('DELETE FROM categoria WHERE codigo_categoria = :codigo_categoria');
    $deleta_categoria->bindParam(':codigo_categoria', $codigo_categoria); 
    $deleta_categoria->execute();

    if(!$deleta_categoria){
        $error_log[] = $deleta_categoria->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_categoria/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir a categoria!")); 
    }else{
        redireciona("/sistema/sessao_categoria/consultar.php?me=".codifica(0,false)."&mm=".codifica("A categoria foi removida com sucesso!")); 
    }

}

if($_GET["codigo_subcategoria"]){

    $codigo_subcategoria        = protege(decodifica($_GET["codigo_subcategoria"]));

    $deleta_vinculo_subcategoria = $pdo->prepare('DELETE FROM produto_subcategoria WHERE codigo_subcategoria = :codigo_subcategoria');
    $deleta_vinculo_subcategoria->bindParam(':codigo_subcategoria', $codigo_subcategoria); 
    $deleta_vinculo_subcategoria->execute();
  
	$deleta_subcategoria = $pdo->prepare('DELETE FROM subcategoria WHERE codigo_subcategoria = :codigo_subcategoria');
    $deleta_subcategoria->bindParam(':codigo_subcategoria', $codigo_subcategoria); 
    $deleta_subcategoria->execute();

    if(!$deleta_subcategoria){
        $error_log[] = $deleta_subcategoria->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_categoria/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir a subcategoria!")); 
    }else{
        redireciona("/sistema/sessao_categoria/consultar.php?me=".codifica(0,false)."&mm=".codifica("A subcategoria foi removida com sucesso!")); 
    }

}

?>