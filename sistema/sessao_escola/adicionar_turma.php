<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if(decodifica($_POST["acao"]) == "adicionar-turma"){

    $escola          = $_POST["escola"];
    $nome_turma      = $_POST["nome_turma"];
    $nivel_turma     = $_POST["nivel_turma"];

    // Insere o produto
    $turma = $pdo->prepare("INSERT INTO turma 
                            (codigo_escola, nivel_turma, nome_turma, status)
                            VALUES
                            (:codigo_escola, :nivel_turma, :nome_turma, :status)");

    $turma->execute(array(
        ':codigo_escola' => $escola,
        ':nivel_turma' => $nivel_turma,
        ':nome_turma' => $nome_turma,
        ':status' => 'L'
    ));

    if(!$turma){
        $error_log[] = $turma->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_escola/turmas.php?codigo_escola=".codifica($escola)."&me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na inclusão da turma!")); 
    }else{
        redireciona("/sistema/sessao_escola/turmas.php?codigo_escola=".codifica($escola)."&me=".codifica(0,false)."&mm=".codifica("A turma foi adicionada com sucesso!")); 
    }
}

?>