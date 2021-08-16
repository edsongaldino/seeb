<?php
// informações do banco de dados (SITE)
define("BD_HOST","euripedesbarsanulfo.org.br");
define("BD_USUARIO","euripede_sistema");
define("BD_SENHA","6ZL0gyC6^H,#");
define("BD_BANCO","euripede_sistema");


// informações do painel
define("TITULO_OFF","Datapix");
define("KEY_SESSAO",$_SERVER['HTTP_HOST'].BD_USUARIO."fdsa65f4sd699q8745sdf987fsd85652734857349eh39rf6dsa8f48f494w84sdf84sd".$_SERVER['REMOTE_ADDR']);
define("DOMINIO","http://".$_SERVER['HTTP_HOST']);

// informacoes google analytics
define("GA_ID_SITE","60096620");
define("GA_LOGIN","web@lancamentosonline.com.br");
define("GA_SENHA","lan2012online");

// informações de aviso ao administrador do sistema
define("ADMIN_RAZAO","Datapix Tecnologia");
define("ADMIN_NOME","Datapix Tecnologia");
define("ADMIN_EMAIL","web@datapix.com.br");
define("ADMIN_SITE","http://www.datapix.com.br/");

// informações do sendgrid
define("SENDGRID_USUARIO","lancamentosonline");
define("SENDGRID_SENHA","lan30252070");

// informações do fuso horário
date_default_timezone_set('America/Cuiaba');
?>