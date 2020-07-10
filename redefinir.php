<?php
require "config.php";

if(!empty($_GET['token'])) {
	$token = $_GET['token'];

	$sql = $pdo->prepare("SELECT * FROM usuarios_token WHERE hash = :hash AND used = 0 AND expired_in > NOW()");
	$sql->bindValue(":hash", $token);
	$sql->execute();

	if($sql->rowCount() > 0) {
		$sql = $sql->fetch();
		$id = $sql['id_usuario'];

			if(!empty($_POST['senha'])) {
				$senha = $_POST['senha'];
				
				$sql = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
				$sql->bindValue(":senha", $senha);
				$sql->bindValue(":id", $id);
				$sql->execute();

				$sql = $pdo->prepare("UPDATE usuarios_token SET used = 1 WHERE hash = :hash");
				$sql->bindValue(":hash", $token);
				$sql->execute();

				echo "Senha alterada com sucesso";
			}
		?>
		<form method="POST">
			Digite a nova senha:</br>
			<input type="password" name="senha"><br/><br/>

			<input type="submit" value="Mudar senha">
		</form>

		<?php
	} else {
		echo "Token inválido ou utilizado!";
		exit;
	}
} else {
	header('Location: index.php');
}
?>