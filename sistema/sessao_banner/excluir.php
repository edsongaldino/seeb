<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if($_GET["codigo_banner"]){

    $codigo_banner        = protege(decodifica($_GET["codigo_banner"]));
 
	$deleta_banner = $pdo->prepare('DELETE FROM banner WHERE codigo_banner = :codigo_banner');
    $deleta_banner->bindParam(':codigo_banner', $codigo_banner); 
    $deleta_banner->execute();

    if(!$deleta_banner){
        $error_log[] = $deleta_banner->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_banner/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir o banner!")); 
    }else{
        redireciona("/sistema/sessao_banner/consultar.php?me=".codifica(0,false)."&mm=".codifica("O banner foi removida com sucesso!")); 
    }

}

?>