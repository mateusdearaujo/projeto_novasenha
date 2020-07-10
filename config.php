<?php
try {
	$pdo = new PDO("mysql:dbname=projeto_esqueciasenha;host=localhost", "mateus", "");
} catch(PDOException $e) {
	Echo "Erro: ".$e->getMessage();
	exit;
}
?>