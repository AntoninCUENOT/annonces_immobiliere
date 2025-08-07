<?php 

namespace Config;

class Auth
{
    public static function isConnected(): bool {
        return isset($_SESSION['user']);
    }

    public static function role(): ?string {
        return $_SESSION['role'] ?? null;
    }

    public static function isAdmin(): bool {
        return self::role() === 'admin';
    }

    public static function isAgent(): bool {
        return self::role() === 'agent';
    }

    public static function isUser(): bool {
        return self::role() === 'user';
    }

    public static function checkAccess(array $allowedRoles): void {
        if (!self::isConnected() || !in_array(self::role(), $allowedRoles)) {
            $_SESSION['error'] = "Accès refusé.";
            header('Location: /');
            exit();
        }
    }
}
