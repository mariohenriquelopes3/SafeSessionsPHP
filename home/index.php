<?php
	include_once __DIR__ . '/' . '../src/controle/HomeControle.php';
	$controle = new HomeControle();
	$retorno = $controle->index();
	include_once __DIR__ . '/' . '../src/view/home/index.php';
?>