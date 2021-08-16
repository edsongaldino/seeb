<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if(decodifica($_POST["acao"]) == "adicionar-item-lista"){

    $codigo_turma          = decodifica($_POST["codigo_turma"]);
    $codigo_produto          = $_POST["codigo_produto"];
    $quantidade             = $_POST["quantidade"];
    $valor_produto         = $_POST["valor_produto"];

    // Insere o produto
    $turma_lista = $pdo->prepare("INSERT INTO lista 
                            (codigo_turma, codigo_produto, quantidade, valor_unitario)
                            VALUES
                            (:codigo_turma, :codigo_produto, :quantidade, :valor_unitario)");

    $turma_lista->execute(array(
        ':codigo_turma' => $codigo_turma,
        ':codigo_produto' => $codigo_produto,
        ':quantidade' => $quantidade,
        ':valor_unitario' => converte_valor_mysql($valor_produto)
    ));

    if(!$turma_lista){
        $error_log[] = $turma_lista->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_escola/lista.php?codigo_turma=".codifica($codigo_turma)."&me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na inclusão do item!")); 
    }else{
        redireciona("/sistema/sessao_escola/lista.php?codigo_turma=".codifica($codigo_turma)."&me=".codifica(0,false)."&mm=".codifica("O produto foi adicionada com sucesso na lista!")); 
    }
}

?>