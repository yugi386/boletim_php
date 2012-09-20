<?php

class cpfcnpjLib {

function replace($string) {
	return $string = str_replace("/","", str_replace("-","",str_replace(".","",$string)));
}

function check_fake($string, $length) {
	for($i = 0; $i <= 9; $i++) {
		$fake = str_pad("", $length, $i);
		if($string === $fake)
			return(1);
	}
}

function cpf($cpf) {

	$cpf = $this->replace($cpf);
	$cpf = trim($cpf);
	if(empty($cpf) || strlen($cpf) != 11)
		return FALSE;
	else{
	if($this->check_fake($cpf, 11))
		return FALSE;
	else{
		$sub_cpf = substr($cpf, 0, 9);

	for($i = 0; $i <= 9; $i++) {
		$dv += ($sub_cpf[$i] * (10-$i));
	}
	if($dv == 0)
		return FALSE;
		
		$dv = 11 - ($dv % 11);
	if($dv > 9)
		$dv = 0;
	if($cpf[9] != $dv)
		return FALSE;

	$dv *= 2;
	for($i = 0; $i <= 9; $i++) {
		$dv += ($sub_cpf[$i] * (11-$i));
	}
	$dv = 11 - ($dv % 11);
	if($dv > 9)
		$dv = 0;
	if($cpf[10] != $dv)
	return FALSE;
	
return TRUE;
	}
	}
}

function cnpj($cnpj)
{
$cnpj = $this->replace($cnpj);
$cnpj = trim($cnpj);
if(empty($cnpj) || strlen($cnpj) != 14)
return FALSE;
else{
if($this->check_fake($cnpj, 14))
return FALSE;
else{
$rev_cnpj = strrev(substr($cnpj, 0, 12));
for($i = 0; $i <= 11; $i++) {
$i == 0 ? $multiplier = 2 : $multiplier;
$i == 8 ? $multiplier = 2 : $multiplier;
$multiply = ($rev_cnpj[$i] * $multiplier);
$sum = $sum + $multiply;
$multiplier++;
}
$rest = $sum % 11;
if($rest == 0 || $rest == 1)
$dv1 = 0;
else
$dv1 = 11 - $rest;

$sub_cnpj = substr($cnpj, 0, 12);
$rev_cnpj = strrev($sub_cnpj.$dv1);
unset($sum);
for($i = 0; $i <= 12; $i++) {

$i == 0 ? $multiplier = 2 : $multiplier;
$i == 8 ? $multiplier = 2 : $multiplier;
$multiply = ($rev_cnpj[$i] * $multiplier);
$sum = $sum + $multiply;
$multiplier++;
}
$rest = $sum % 11;
if($rest == 0 || $rest == 1)
$dv2 = 0;
else
$dv2 = 11 - $rest;

if($dv1 == $cnpj[12] && $dv2 == $cnpj[13])
return TRUE;
else
return FALSE;
}
}
}
}