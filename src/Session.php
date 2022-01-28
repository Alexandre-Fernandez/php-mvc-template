<?php declare(strict_types=1);
namespace App;

class Session {
	private const MAX_INACTIVITY = 1800000; // 1800000 ms = 30 minutes
		
	/**
	 * starts the session and verifies its validity
	 */
	public static function init() {
		session_start();
		if(time() - $_SESSION["LAST_ACTIVE"] > self::MAX_INACTIVITY) return self::destroy();
		$_SESSION["LAST_ACTIVE"] = time();
	}

	public static function write(string $key, mixed $value) {
		self::start();
		$_SESSION[$key] = $value;
	}

	public static function read(string $key): mixed {
		self::start();
		return $_SESSION[$key];
	}
	
	public static function destroy() {
		if(session_status() === PHP_SESSION_NONE) session_start();
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		session_destroy();
	}

	/**
	 * starts the session if needed and timestamps it with the current time
	 */
	private static function start() {
		if(session_status() === PHP_SESSION_NONE) session_start();
		$_SESSION["LAST_ACTIVE"] = time();
	}
}