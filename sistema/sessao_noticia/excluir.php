<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if($_GET["codigo_noticia"]){

    $codigo_noticia        = protege(decodifica($_GET["codigo_noticia"]));
 
	$deleta_noticia = $pdo->prepare('DELETE FROM noticia WHERE codigo_noticia = :codigo_noticia');
    $deleta_noticia->bindParam(':codigo_noticia', $codigo_noticia); 
    $deleta_noticia->execute();

    if(!$deleta_noticia){
        $error_log[] = $deleta_noticia->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_noticia/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir a noticia!")); 
    }else{
        redireciona("/sistema/sessao_noticia/consultar.php?me=".codifica(0,false)."&mm=".codifica("A noticia foi removida com sucesso!")); 
    }

}

?>