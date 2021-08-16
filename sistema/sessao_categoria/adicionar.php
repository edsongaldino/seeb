<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if(decodifica($_POST["acao"]) == "adicionar-categoria"){

    $nome_categoria               = $_POST["nome_categoria"];

    // Insere o produto
    $categoria = $pdo->prepare("INSERT INTO categoria 
                            (nome_categoria, 
                            status)
                            VALUES
                            (:nome_categoria,
                            :status)");

    $categoria->execute(array(
        ':nome_categoria' => $nome_categoria,
        ':status' => 'L'
    ));

    if(!$categoria){
        $error_log[] = $categoria->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_categoria/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na inclusão da categoria!")); 
    }else{
        redireciona("/sistema/sessao_categoria/consultar.php?me=".codifica(0,false)."&mm=".codifica("A categoria foi adicionada com sucesso!")); 
    }
}


if(decodifica($_POST["acao"]) == "adicionar-subcategoria"){

    $nome_subcategoria = $_POST["nome_subcategoria"];
    $codigo_categoria = $_POST["categoria"];

    // Insere o produto
    $subcategoria = $pdo->prepare("INSERT INTO subcategoria 
                            (codigo_categoria, nome_subcategoria,status)
                            VALUES
                            (:codigo_categoria,:nome_subcategoria,:status)");

    $subcategoria->execute(array(
        ':codigo_categoria' => $codigo_categoria,
        ':nome_subcategoria' => $nome_subcategoria,
        ':status' => 'L'
    ));

    if(!$subcategoria){
        $error_log[] = $subcategoria->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_categoria/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na inclusão da subcategoria!")); 
    }else{
        redireciona("/sistema/sessao_categoria/consultar.php?me=".codifica(0,false)."&mm=".codifica("A subcategoria foi adicionada com sucesso!")); 
    }
}

?>