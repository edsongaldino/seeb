<?php
function remove_caracter_especial($texto) {
	$texto = strtolower(strtr($texto, "�������������������������� -", "aaaaeeiooouucAAAAEEIOOOUUC__"));
	$texto = ereg_replace("[^a-zA-Z0-9_]", "", $texto);
	
	return $texto;
}
?>