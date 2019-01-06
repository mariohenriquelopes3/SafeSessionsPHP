<?php

include_once __DIR__ . '/' . '../dao/HomeDAO.php';
include_once __DIR__ . '/' . '../modelo/Session.php';

class HomeControle {

	public $lista;
	public $session;

	const SIGNATURE = "zZzZzZ123456";
	const ID_SESSION = "idSession";
	const ID_SESSION_SEG = "idSessionSeg";
	const KEY_SESSION = "keySession";

	public function index() {
		$idSession = $this->getIdSessionCookie();
		$keySession = $this->getKeySessionCookie();
		$this->session = home_dao_get_session($idSession, $keySession);
		if ($this->session == null) {
			$this->session = new Session();
			$this->session->keySession = $this->genKeySession();
			home_dao_save_session($this->session);
			
			setcookie(HomeControle::ID_SESSION,     $this->session->id,                                           2147483647, '/');
            setcookie(HomeControle::ID_SESSION_SEG, hash('sha256', $this->session->id . HomeControle::SIGNATURE), 2147483647, '/');
            setcookie(HomeControle::KEY_SESSION,    $this->session->keySession,                                                       2147483647, '/');
		}
		return 1;
	}
	public function getIdSessionCookie() {
		$idCookie = ((array_key_exists(HomeControle::ID_SESSION, $_COOKIE)) ? $_COOKIE[HomeControle::ID_SESSION] : null);
        $idCookieSign = ((array_key_exists(HomeControle::ID_SESSION_SEG, $_COOKIE)) ? $_COOKIE[HomeControle::ID_SESSION_SEG] : null);

        if ($idCookie != null && $idCookieSign != null) {
            $idHashCookie = $idCookie;
            $idHashCookie .= HomeControle::SIGNATURE;
            $idHashCookie = hash('sha256', $idHashCookie);
            if ($idHashCookie === $idCookieSign) {
                return $idCookie;
            }
        }
        return null;
	}
	public function getKeySessionCookie() {
		return ((array_key_exists(HomeControle::KEY_SESSION, $_COOKIE)) ? $_COOKIE[HomeControle::KEY_SESSION] : null);
	}

	public function genKeySession() {
		$aleatorio = '';
        $letras = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz!@#$%();[]';
        for ($i = 0; $i < 50; $i++) {
            $idx = rand(0, (strlen($letras) - 1));
            $aleatorio .= substr($letras, $idx, 1);
        }
        return $aleatorio;
	}

}
?>