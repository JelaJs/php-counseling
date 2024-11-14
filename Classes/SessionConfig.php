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
        
        if (!isset($_SESSION['last_regeneration']) || 
            (time() - $_SESSION['last_regeneration'] >= $this->regenerationInterval)) {
            $this->regenerateSession();
        }
    }

    private function regenerateSession()
    {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}
