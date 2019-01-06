<?php

include_once __DIR__ . '/' . '../modelo/Session.php';

function getConnection() {
	/*
		SCRIPT DA TABELA DE SESSAO:
		-------------------
		CREATE TABLE session (
			idSession bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			keySession varchar(255),
			dataHora datetime,
			PRIMARY KEY (idSession)
		);
		-------------------
	*/

	return new mysqli("localhost", "usuario", "senha", "db_name");

}

function home_dao_save_session($session) {
	$connection = getConnection();
	$connection->query("insert into session (dataHora, keySession)
			values ('" . $connection->real_escape_string($session->dataHora) . "',
					'" . $connection->real_escape_string($session->keySession) . "')");

	$session->id = $connection->query('select last_insert_id() last_id from dual')->fetch_assoc()['last_id'];
	return;
}

function home_dao_get_session($idSession, $keySession) {
	$connection = getConnection();

	$sql = "select * from session where idSession = '" . $connection->real_escape_string($idSession) . "'
			and BINARY keySession = '" . $connection->real_escape_string($keySession) . "'";

	$session = null;

	if ($result = $connection->query($sql)) {
		while ($linha = $result->fetch_assoc()) {
			$session = new Session();
			$session->id = $linha['idSession'];
			$session->keySession = $linha['keySession'];
			$session->dataHora = $linha['dataHora'];
		}
		$result->free();
	}

	$connection->close();

	return $session;
}

?>