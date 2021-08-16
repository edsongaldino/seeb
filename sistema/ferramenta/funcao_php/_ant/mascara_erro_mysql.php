<?php
function mascara_erro_mysql($sql,$modulo = false,$personalizado = false) {
	global $begin_transacao;
	$erro_numero = mysql_errno();
	$erro_msg = mysql_error();
	
	if(isset($begin_transacao)) {
		// fim da transacao
		$query_rollback = mysql_query("ROLLBACK");
	}
	
	fecha_mysql();
	
	// erro 1048 = n�o � poss�vel incluir valores NULL onde n�o aceita NULL
	if($erro_numero == 1048) {
		$txt_mensagem = "Os campos obrigat�rios destacado por * devem ser preenchidos corretamente";

		if($modulo) {
			redireciona_modulo(false,true,$txt_mensagem);
		} elseif($personalizado) {
			redireciona($personalizado);
		} else {
			redireciona("consultar.php?me=".campo_form_codifica(1,true)."&mm=".campo_form_codifica($txt_mensagem));
		}
		
	// erro 1451 = n�o � poss�vel deletar registro com dependencia estrangeiras
	} elseif($erro_numero == 1451) {
		$txt_mensagem = "N�o � poss�vel deletar ou editar registros com depend�ncias";
		
		if($modulo) {
			redireciona_modulo(false,true,$txt_mensagem);
		} elseif($personalizado) {
			redireciona($personalizado);
		} else {
			redireciona("consultar.php?me=".campo_form_codifica(1,true)."&mm=".campo_form_codifica($txt_mensagem));
		}

	// erro 1062 = n�o � poss�vel incluir registro duplicados
	} elseif($erro_numero == 1062) {
		$txt_mensagem = "N�o � poss�vel cadastrar informa��es duplicadas";
		
		if($modulo) {
			redireciona_modulo(false,true,$txt_mensagem);
		} elseif($personalizado) {
			redireciona($personalizado);
		} else {
			redireciona("consultar.php?me=".campo_form_codifica(1,true)."&mm=".campo_form_codifica($txt_mensagem));
		}

	// demais erros
	} else {
		// envia aviso de erro
		$erro_assunto = "Erro MySQL n�mero ".$erro_numero.", usu�rio ".$_SESSION["usuario_acesso"];
		$erro_mensagem = "<strong>".date("m-d-Y", time())." ".date("H:i:s", time())."</strong><br><br>Ocorreu um erro no endere�o ".$_SERVER['SCRIPT_FILENAME']."<br><br><strong>MySQL erro:</strong> ".$erro_msg."<br><strong>MySQL n�mero erro:</strong> ".$erro_numero."<br><strong>SQL:</strong> ".$sql;
		registra_erro($erro_assunto,$erro_mensagem);
	
		echo '
			  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			  <html xmlns="http://www.w3.org/1999/xhtml">
			  <head>
			  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			  <title>Erro fatal</title>
			  </head>
			  <body bgcolor="#ddd">
			  <div align="center">
			  <h2>Ocorreu um erro fatal</h2><br />
			  <h3>Erro MySQL n�mero '.$erro_numero.'</h3><br />
			  <h3>Por favor, avise ao administrador do sistema '.ADMIN_NOME.' ('.ADMIN_EMAIL.')</h3>
			  <!-- MySQL erro: '.$erro_msg.' -->
			  <!-- MySQL n�mero erro: '.$erro_numero.' -->
			  <!-- SQL: '.$sql.' -->
			  </div>
			  </body>
			  </html>
			  ';
		die();
	}
}
?>