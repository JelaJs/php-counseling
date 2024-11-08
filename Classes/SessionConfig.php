<?php
class SessionConfig {
    private $sessionLifetime = 1800; // Session lifetime in seconds (30 minutes)
    private $regenerationInterval = 1800; // Interval for session ID regeneration (30 minutes)

    public function __construct()
    {
        // Initialize session configuration
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_strict_mode', 1);

        session_set_cookie_params([
            'lifetime' => $this->sessionLifetime,
            'domain' => 'localhost',
            'path' => '/',
            'secure' => false, // Set to true if using HTTPS
            'httponly' => true
        ]);
    }

    public function startSession()
    {
        session_start();

        if(isset($_SESSION['user_id'])) {
            if (!isset($_SESSION['last_regeneration'])) {
                $this->regenerate_session_id_loggedin();
            } else {
                if (time() - $_SESSION['last_regeneration'] >= $this->regenerationInterval) {
                    $this->regenerate_session_id_loggedin();
                }
            }
        }else {
            if (!isset($_SESSION['last_regeneration'])) {
                $this->regenerateSession();
            } else {
                if (time() - $_SESSION['last_regeneration'] >= $this->regenerationInterval) {
                    $this->regenerateSession();
                }
            }
        }

    }

    private function regenerateSession()
    {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }

    private function regenerateSession_userlogin() {
        session_regenerate_id(true);

        $userId = $_SESSION['user_id'];
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $userId;
        session_id($sessionId);

        $_SESSION['last_regeneration'] = time();
    }
}
