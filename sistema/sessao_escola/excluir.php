<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if($_GET["codigo_escola"]){

    $codigo_escola        = protege(decodifica($_GET["codigo_escola"]));
 
	$deleta_escola = $pdo->prepare('DELETE FROM escola WHERE codigo_escola = :codigo_escola');
    $deleta_escola->bindParam(':codigo_escola', $codigo_escola); 
    $deleta_escola->execute();

    if(!$deleta_escola){
        $error_log[] = $deleta_escola->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_escola/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir a escola!")); 
    }else{
        redireciona("/sistema/sessao_escola/consultar.php?me=".codifica(0,false)."&mm=".codifica("A escola foi removida com sucesso!")); 
    }

}

if($_GET["codigo_lista"]){

    $codigo_lista        = protege(decodifica($_GET["codigo_lista"]));

    //consulta escolas
    $sql_consulta_turma = "SELECT codigo_turma FROM lista WHERE codigo_lista = '".$codigo_lista."'";
    $result = $pdo->query( $sql_consulta_turma );
    $turma = $result->fetch( PDO::FETCH_ASSOC );
 
	$deleta_lista = $pdo->prepare('DELETE FROM lista WHERE codigo_lista = :codigo_lista');
    $deleta_lista->bindParam(':codigo_lista', $codigo_lista); 
    $deleta_lista->execute();

    if(!$deleta_lista){
        $error_log[] = $deleta_lista->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_escola/lista.php?codigo_turma=".codifica($turma["codigo_turma"])."&me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir a escola!")); 
    }else{
        redireciona("/sistema/sessao_escola/lista.php?codigo_turma=".codifica($turma["codigo_turma"])."&me=".codifica(0,false)."&mm=".codifica("A escola foi removida com sucesso!")); 
    }

}

if($_GET["codigo_turma"]){

    $codigo_turma = protege(decodifica($_GET["codigo_turma"]));

    //consulta escolas
    $sql_consulta_escola = "SELECT turma.codigo_escola FROM turma WHERE turma.codigo_turma = '".$codigo_turma."'";
    $query_escola = $pdo->query( $sql_consulta_escola );
    $escola = $query_escola->fetch( PDO::FETCH_ASSOC );
 
	$deleta_turma = $pdo->prepare('DELETE FROM turma WHERE codigo_turma = :codigo_turma');
    $deleta_turma->bindParam(':codigo_turma', $codigo_turma); 
    $deleta_turma->execute();

    if(!$deleta_turma){
        $error_log[] = $deleta_turma->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_escola/turmas.php?codigo_escola=".codifica($escola["codigo_escola"])."&me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado ao excluir a turma!")); 
    }else{
        redireciona("/sistema/sessao_escola/turmas.php?codigo_escola=".codifica($escola["codigo_escola"])."&me=".codifica(0,false)."&mm=".codifica("A turma foi removida com sucesso!")); 
    }

}

?>