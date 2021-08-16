<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if(decodifica($_POST["acao"]) == "adicionar-fabricante"){

    $nome_fabricante               = $_POST["nome_fabricante"];

    // Insere o produto
    $fabricante = $pdo->prepare("INSERT INTO fabricante 
                            (nome_fabricante, 
                            status)
                            VALUES
                            (:nome_fabricante,
                            :status)");

    $fabricante->execute(array(
        ':nome_fabricante' => $nome_fabricante,
        ':status' => 'L'
    ));

    if(!$fabricante){
        $error_log[] = $fabricante->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_fabricante/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na inclusão da fabricante!")); 
    }else{
        redireciona("/sistema/sessao_fabricante/consultar.php?me=".codifica(0,false)."&mm=".codifica("A fabricante foi adicionada com sucesso!")); 
    }
}


if(decodifica($_POST["acao"]) == "adicionar-subfabricante"){

    $nome_subfabricante = $_POST["nome_subfabricante"];
    $codigo_fabricante = $_POST["fabricante"];

    // Insere o produto
    $subfabricante = $pdo->prepare("INSERT INTO subfabricante 
                            (codigo_fabricante, nome_subfabricante,status)
                            VALUES
                            (:codigo_fabricante,:nome_subfabricante,:status)");

    $subfabricante->execute(array(
        ':codigo_fabricante' => $codigo_fabricante,
        ':nome_subfabricante' => $nome_subfabricante,
        ':status' => 'L'
    ));

    if(!$subfabricante){
        $error_log[] = $subfabricante->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_fabricante/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na inclusão da subfabricante!")); 
    }else{
        redireciona("/sistema/sessao_fabricante/consultar.php?me=".codifica(0,false)."&mm=".codifica("A subfabricante foi adicionada com sucesso!")); 
    }
}

?>