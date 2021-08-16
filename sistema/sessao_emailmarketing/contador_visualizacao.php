<?php require_once("../sistema_mod_include_externo.php"); ?>
<?php
ini_set('display_errors', 1);


if($_GET["codigo_emkt_envio_contato"]){

    //Abre a conexão
    $pdo = Database::conexao();


    $codigo_emkt_envio_contato = protege(decodifica($_GET["codigo_emkt_envio_contato"]));
    $data_leitura_emkt_envio_contato = date("Y-m-d H:i:s", time());

    // Insere o produto
    $envio = $pdo->prepare("UPDATE emkt_envio_contato SET data_leitura_emkt_envio_contato = :data_leitura_emkt_envio_contato WHERE codigo_emkt_envio_contato = :codigo_emkt_envio_contato");

    $envio->execute(array(
        ':codigo_emkt_envio_contato' => $codigo_emkt_envio_contato,
        ':data_leitura_emkt_envio_contato' => $data_leitura_emkt_envio_contato
    ));


}

?>