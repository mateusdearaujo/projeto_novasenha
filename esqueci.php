<?php
require "config.php";

if(!empty($_POST['email'])) {
	$email = $_POST['email'];
	$sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
	$sql->bindValue(":email", $email);
	$sql->execute();

	if($sql->rowCount() > 0) {
		$sql = $sql->fetch();
		$id = $sql['id'];

		$token = md5(time().rand(0, 99999).rand(0, 99999));

		$sql = $pdo->prepare("INSERT INTO usuarios_token (id_usuario, hash, expired_in) VALUES (:id_usuario, :hash, :expired_in)");
		$sql->bindValue(":id_usuario", $id);
		$sql->bindValue(":hash", $token);
		$sql->bindValue(":expired_in", date('Y-m-d H:i', strtotime('+2 months')));
		$sql->execute();

		$link = "localhost/estudo/redefinir.php?token=".$token;

		echo "Clique para redefinir sua senha<br/><br/>";
		echo $link;
	}
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<form action="" method="POST">
	Qual seu e-mail?<br/><br/>
	<input type="email" name="email"><br/><br/>

	<input type="submit" value="Enviar">
</form>
</body>
</html>