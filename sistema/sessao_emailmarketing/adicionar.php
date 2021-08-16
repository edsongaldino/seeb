<?php require_once("../sistema_mod_include.php");?>
<?php
//Abre a conexão
$pdo = Database::conexao();

if(decodifica($_POST["acao"]) == "adicionar-grupo"){

    $titulo_emkt_grupo               = $_POST["nome_grupo"];

    // Insere o produto
    $grupo = $pdo->prepare("INSERT INTO emkt_grupo 
                            (titulo_emkt_grupo, 
                            status_emkt_grupo)
                            VALUES
                            (:titulo_emkt_grupo,
                            :status_emkt_grupo)");

    $grupo->execute(array(
        ':titulo_emkt_grupo' => $titulo_emkt_grupo,
        ':status_emkt_grupo' => 'L'
    ));

    if(!$grupo){
        $error_log[] = $grupo->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_emailmarketing/grupos_contatos.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na inclusão do grupo!")); 
    }else{
        redireciona("/sistema/sessao_emailmarketing/grupos_contatos.php?me=".codifica(0,false)."&mm=".codifica("O grupo foi adicionado com sucesso!")); 
    }
}


if(decodifica($_POST["acao"]) == "adicionar-contato"){

    $nome_emkt_contato = $_POST["nome_contato"];
    $email_emkt_contato = $_POST["email_contato"];
    $codigo_emkt_grupo = $_POST["grupo"];

    // Insere o produto
    $contato = $pdo->prepare("INSERT INTO emkt_contato 
                            (nome_emkt_contato, email_emkt_contato,status_emkt_contato)
                            VALUES
                            (:nome_emkt_contato,:email_emkt_contato,:status_emkt_contato)");

    $contato->execute(array(
        ':nome_emkt_contato' => $nome_emkt_contato,
        ':email_emkt_contato' => $email_emkt_contato,
        ':status_emkt_contato' => 'L'
    ));

    $codigo_emkt_contato = $pdo->lastInsertId();

    if(!$contato){
        $error_log[] = $contato->errorInfo();
    }

    // Vincula contato ao grupo
    $grupo_contato = $pdo->prepare("INSERT INTO emkt_grupo_contato 
                            (codigo_emkt_grupo, codigo_emkt_contato)
                            VALUES
                            (:codigo_emkt_grupo,:codigo_emkt_contato)");

    $grupo_contato->execute(array(
        ':codigo_emkt_grupo' => $codigo_emkt_grupo,
        ':codigo_emkt_contato' => $codigo_emkt_contato
    ));

    if(!$grupo_contato){
        $error_log[] = $grupo_contato->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_emailmarketing/grupos_contatos.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na inclusão do contato!")); 
    }else{
        redireciona("/sistema/sessao_emailmarketing/grupos_contatos.php?me=".codifica(0,false)."&mm=".codifica("O contato foi adicionada com sucesso!")); 
    }
}

if(decodifica($_POST["acao"]) == "adicionar-envio"){

    $codigo_emkt_envio = decodifica($_POST["codigo_envio"]);
    $codigo_emkt_grupo = $_POST["grupo"];

    if(verifica_envio($codigo_emkt_envio, $codigo_emkt_grupo, $pdo)):
        redireciona("/sistema/sessao_emailmarketing/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, Você já fez um disparo para este grupo!")); 
    else:

    // Vincula envio ao grupo
    $grupo_envio = $pdo->prepare("INSERT INTO emkt_envio_grupo 
                            (codigo_emkt_grupo, codigo_emkt_envio)
                            VALUES
                            (:codigo_emkt_grupo,:codigo_emkt_envio)");

    $grupo_envio->execute(array(
        ':codigo_emkt_grupo' => $codigo_emkt_grupo,
        ':codigo_emkt_envio' => $codigo_emkt_envio
    ));

    endif;

    if(!$grupo_envio){
        $error_log[] = $grupo_envio->errorInfo();
    }else{

        //consulta contatos do grupo
        $sql_consulta_contatos = "SELECT codigo_emkt_contato FROM emkt_grupo_contato WHERE codigo_emkt_grupo = '".$codigo_emkt_grupo."'";
        $result = $pdo->query( $sql_consulta_contatos );
        $contatos = $result->fetchAll( PDO::FETCH_ASSOC );

        //Adiciona o envio para os contatos
        foreach($contatos AS $contato):

            // Vincula contato ao envio
            $envio_contato = $pdo->prepare("INSERT INTO emkt_envio_contato 
                                            (codigo_emkt_envio, codigo_emkt_contato, situacao_emkt_envio_contato)
                                            VALUES
                                            (:codigo_emkt_envio,:codigo_emkt_contato, :situacao_emkt_envio_contato)");

            $envio_contato->execute(array(
                ':codigo_emkt_envio' => $codigo_emkt_envio,
                ':codigo_emkt_contato' => $contato["codigo_emkt_contato"],
                ':situacao_emkt_envio_contato' => 'AE' //Aguardando Envio
            ));

            if(!$envio_contato){
                $error_log[] = $envio_contato->errorInfo();
            }
        
        endforeach;

    }

    if($error_log){
        redireciona("/sistema/sessao_emailmarketing/consultar.php?me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na inclusão do envio!")); 
    }else{
        redireciona("/sistema/sessao_emailmarketing/consultar.php?me=".codifica(0,false)."&mm=".codifica("O envio foi adicionado com sucesso!")); 
    }
}

if(decodifica($_GET["acao"]) == "adicionar-produto-envio"){

    $codigo_emkt_envio = decodifica($_GET["codigo_envio"]);
    $codigo_produto = decodifica($_GET["codigo_produto"]);

    // Vincula envio ao produto
    $envio_produto = $pdo->prepare("INSERT INTO emkt_envio_produto 
                            (codigo_produto, codigo_emkt_envio)
                            VALUES
                            (:codigo_produto,:codigo_emkt_envio)");

    $envio_produto->execute(array(
        ':codigo_produto' => $codigo_produto,
        ':codigo_emkt_envio' => $codigo_emkt_envio
    ));

    if(!$envio_produto){
        $error_log[] = $envio_produto->errorInfo();
    }

    if($error_log){
        redireciona("/sistema/sessao_emailmarketing/produtos_envio.php?codigo_emkt_envio=".codifica($codigo_emkt_envio)."&me=".codifica(1,true)."&mm=".codifica("Ops, algo deu errado na inclusão do produto no envio!")); 
    }else{
        redireciona("/sistema/sessao_emailmarketing/produtos_envio.php?codigo_emkt_envio=".codifica($codigo_emkt_envio)."&me=".codifica(0,false)."&mm=".codifica("O produto foi adicionado com sucesso no envio!")); 
    }
}

?>