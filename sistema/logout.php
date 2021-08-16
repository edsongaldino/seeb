<?php include("sistema_mod_include.php"); ?>
<?php
session_destroy();

redireciona("/sistema/index.php?me=".codifica(0,true)."&mm=".codifica("Você saiu do sistema :(. Para entrar novamente faça seu login!"));
?>