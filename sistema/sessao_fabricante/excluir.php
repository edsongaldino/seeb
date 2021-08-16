<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if($_GET["codigo_fabricante"]){

    $codigo_fabricante        = protege(decodifica($_GET["codigo_fabricante"]));
 
	$deleta_fabricante = $pdo->prepare('DELETE FROM fabricante WHERE codigo_fabricante = :codigo_fabricante');
    $deleta_fabricante->bindParam(':codigo_fabricante', $codigo_fabricante); 
    $deleta_fabricante->execute();

    if(!$deleta_fabricante){
        $error_log[] = $deleta_fabricante->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_fabricante/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir a fabricante!")); 
    }else{
        redireciona("/sistema/sessao_fabricante/consultar.php?me=".codifica(0,false)."&mm=".codifica("A fabricante foi removida com sucesso!")); 
    }

}

?>