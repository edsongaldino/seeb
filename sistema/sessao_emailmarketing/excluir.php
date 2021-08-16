<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if($_GET["codigo_grupo"]){

    $codigo_emkt_grupo        = protege(decodifica($_GET["codigo_grupo"]));

    $deleta_vinculo_grupo = $pdo->prepare('DELETE FROM emkt_grupo_contato WHERE codigo_emkt_grupo = :codigo_emkt_grupo');
    $deleta_vinculo_grupo->bindParam(':codigo_emkt_grupo', $codigo_emkt_grupo); 
    $deleta_vinculo_grupo->execute();
  
	$deleta_grupo = $pdo->prepare('DELETE FROM emkt_grupo WHERE codigo_emkt_grupo = :codigo_emkt_grupo');
    $deleta_grupo->bindParam(':codigo_emkt_grupo', $codigo_emkt_grupo); 
    $deleta_grupo->execute();

    if(!$deleta_grupo){
        $error_log[] = $deleta_grupo->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_emailmarketing/grupos_contatos.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir o grupo!")); 
    }else{
        redireciona("/sistema/sessao_emailmarketing/grupos_contatos.php?me=".codifica(0,false)."&mm=".codifica("O grupo foi removido com sucesso!")); 
    }

}

if($_GET["codigo_contato"]){

    $codigo_emkt_contato        = protege(decodifica($_GET["codigo_contato"]));

    $deleta_vinculo_contato = $pdo->prepare('DELETE FROM emkt_grupo_contato WHERE codigo_emkt_contato = :codigo_emkt_contato');
    $deleta_vinculo_contato->bindParam(':codigo_emkt_contato', $codigo_emkt_contato); 
    $deleta_vinculo_contato->execute();
  
	$deleta_contato = $pdo->prepare('DELETE FROM emkt_contato WHERE codigo_emkt_contato = :codigo_emkt_contato');
    $deleta_contato->bindParam(':codigo_emkt_contato', $codigo_emkt_contato); 
    $deleta_contato->execute();

    if(!$deleta_contato){
        $error_log[] = $deleta_contato->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_emailmarketing/grupos_contatos.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir o contato!")); 
    }else{
        redireciona("/sistema/sessao_emailmarketing/grupos_contatos.php?me=".codifica(0,false)."&mm=".codifica("O contato foi removido com sucesso!")); 
    }

}

if($_GET["codigo_envio"]){

    $codigo_emkt_envio        = protege(decodifica($_GET["codigo_envio"]));

    $deleta_vinculo_contato = $pdo->prepare('DELETE FROM emkt_envio_contato WHERE codigo_emkt_envio = :codigo_emkt_envio');
    $deleta_vinculo_contato->bindParam(':codigo_emkt_envio', $codigo_emkt_envio); 
    $deleta_vinculo_contato->execute();

     
	$deleta_envio = $pdo->prepare('DELETE FROM emkt_envio WHERE codigo_emkt_envio = :codigo_emkt_envio');
    $deleta_envio->bindParam(':codigo_emkt_envio', $codigo_emkt_envio); 
    $deleta_envio->execute();

    if(!$deleta_envio){
        $error_log[] = $deleta_envio->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_emailmarketing/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir o envio!")); 
    }else{
        redireciona("/sistema/sessao_emailmarketing/consultar.php?me=".codifica(0,false)."&mm=".codifica("O envio foi removido com sucesso!")); 
    }

}

?>