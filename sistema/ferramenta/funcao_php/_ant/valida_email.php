<?php
function valida_email($email) {
	$email = strtolower(strtr($email, "�������������������������� ,", "aaaaeeiooouucAAAAEEIOOOUUC_."));
	$email = ereg_replace("[^a-z0-9_.@-]", "", $email);
	
	return $email;
}
?>