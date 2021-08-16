<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if($_GET["codigo_depoimento"]){

    $codigo_depoimento        = protege(decodifica($_GET["codigo_depoimento"]));
 
	$deleta_depoimento = $pdo->prepare('DELETE FROM depoimento WHERE codigo_depoimento = :codigo_depoimento');
    $deleta_depoimento->bindParam(':codigo_depoimento', $codigo_depoimento); 
    $deleta_depoimento->execute();

    if(!$deleta_depoimento){
        $error_log[] = $deleta_depoimento->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_depoimento/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir a depoimento!")); 
    }else{
        redireciona("/sistema/sessao_depoimento/consultar.php?me=".codifica(0,false)."&mm=".codifica("A depoimento foi removida com sucesso!")); 
    }

}

?>