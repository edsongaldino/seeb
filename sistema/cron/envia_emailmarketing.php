<?php

	require_once("../ferramenta/configuracoes.php");
	require_once("../ferramenta/funcao_php.php");
	require_once("../ferramenta/Class/pdo.class.php");

	// log cron envios
	$fp = fopen("../cron/log/".date("Ymd",time()).".txt", "a");
	$escreve = fwrite($fp, date("d/m/Y H:i:s",time())."\n");
	fclose($fp);

	//Abre a conexão
    $pdo = Database::conexao();
    
	//consulta envios
    $sql_consulta_envios = "SELECT
	emkt_envio_contato.codigo_emkt_contato,
	emkt_envio_contato.situacao_emkt_envio_contato,
	emkt_envio_contato.codigo_emkt_envio_contato,
	emkt_envio.codigo_emkt_envio,
	emkt_envio.codigo_emkt_tipo_envio,
	emkt_envio.imagem_emkt_envio,
	emkt_envio.link_emkt_envio,
	emkt_envio.titulo_emkt_envio,
	emkt_contato.nome_emkt_contato,
	emkt_contato.email_emkt_contato
	FROM
	emkt_envio
	JOIN emkt_envio_contato ON emkt_envio_contato.codigo_emkt_envio = emkt_envio.codigo_emkt_envio
	JOIN emkt_contato ON emkt_envio_contato.codigo_emkt_contato = emkt_contato.codigo_emkt_contato
	WHERE emkt_envio_contato.situacao_emkt_envio_contato = 'AE'
	GROUP BY emkt_envio_contato.codigo_emkt_contato ORDER BY RAND() LIMIT 1";
    $result = $pdo->query( $sql_consulta_envios );
    $envios = $result->fetchAll( PDO::FETCH_ASSOC );

	foreach($envios as $envio){


        if($envio['codigo_emkt_tipo_envio'] == 1){
            require_once('../ferramenta/templates_email/template_envio_imagem.php');
        }elseif($envio['codigo_emkt_tipo_envio'] == 2){


			//consulta produtos do envio
			$sql_consulta_produtos = "SELECT
			produto.codigo_produto,
			produto.nome_produto,
			produto.descricao_produto,
			foto_produto.arquivo_foto
			FROM
			produto
			JOIN foto_produto ON foto_produto.codigo_produto = produto.codigo_produto
			JOIN emkt_envio_produto ON emkt_envio_produto.codigo_produto = produto.codigo_produto
			JOIN emkt_envio ON emkt_envio.codigo_emkt_envio = emkt_envio_produto.codigo_emkt_envio
			WHERE emkt_envio.codigo_emkt_envio = '".$envio['codigo_emkt_envio']."'";
			$result = $pdo->query( $sql_consulta_produtos );
			$produtos = $result->fetchAll( PDO::FETCH_ASSOC );


            require_once('../ferramenta/templates_email/template_envio_produto.php');
		}
		
		// Novo Layout Email
		$corpo_mensagem = $template_email;

		// alerta email
		$url = 'https://api.sendgrid.com/';
		$params = array(
			"api_user" => SENDGRID_USUARIO,
			"api_key" => SENDGRID_SENHA,
			"to" => $envio["email_emkt_contato"],
			"subject" => $envio["titulo_emkt_envio"],
			"html" => $corpo_mensagem,
			"text" => "Para visualizar este e-mail você deve possuir um programa que suporte html.",
			"from" => "divulgacao@euripedesbarsanulfo.org.br"
		);
		
		$request =  $url."api/mail.send.json";
		
		// Generate curl request
		$session = curl_init($request);

		curl_setopt($session, CURLOPT_POST, true);
		curl_setopt($session, CURLOPT_POSTFIELDS, $params);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		
		// obtain response
		$response = curl_exec_follow($session);

		curl_close($session);
		
		if($response == '{"message":"success"}') {
	

			// Atualiza envio
			$atualiza_situacao = $pdo->prepare("UPDATE emkt_envio_contato SET situacao_emkt_envio_contato = :situacao_emkt_envio_contato, data_emkt_envio_contato = :data_emkt_envio_contato WHERE codigo_emkt_envio_contato = :codigo_emkt_envio_contato");
			$atualiza_situacao->execute(array(
			':data_emkt_envio_contato' => date("Y-m-d H:i:s",time()),
			':situacao_emkt_envio_contato' => 'ER',
			':codigo_emkt_envio_contato' => $envio["codigo_emkt_envio_contato"]
			));

			if(!$atualiza_situacao){
				$error_log[] = $envio->errorInfo();
			}
		
			echo "E-mail enviado para ".$envio["nome_destinatario"]." (".$envio["email_emkt_contato"].")";
			$envio["email_emkt_contato"] = '' ;
			$envio["nome_emkt_contato"] = '' ;
			

			$atualiza_situacao->closeCursor();

			//echo 'envio realizado com sucesso';

		} else {

			$deleta_envio_erro = $pdo->prepare('DELETE FROM emkt_envio_contato WHERE codigo_emkt_envio_contato = :codigo_emkt_envio_contato');
			$deleta_envio_erro->bindParam(':codigo_emkt_envio_contato', $envio["codigo_emkt_envio_contato"]); 
			$deleta_envio_erro->execute();

			echo 'Erro ao enviar email';


		}
		
	}

?>