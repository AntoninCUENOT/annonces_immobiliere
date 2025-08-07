<?php

namespace Models;

require_once __DIR__ . '/../database/Database.php';

use Config\Database\Database;
use PDO;

class RegisterModel
{
    private string $email;
    private string $password;
    private string $confirmPassword;
    private ?PDO $db;

    public function __construct(array $postData)
    {
        $this->email = trim($postData['email'] ?? '');
        $this->password = $postData['password'] ?? '';
        $this->confirmPassword = $postData['confirm_password'] ?? '';
        $this->db = Database::getConnection();
    }

    public function isValid(): bool
    {
        return !empty($this->email)
            && !empty($this->password)
            && $this->password === $this->confirmPassword
            && !$this->emailExists();
    }

    private function emailExists(): bool
    {
        $query = "SELECT id FROM user WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }

    public function register(): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (email, password) VALUES (:email, :password)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getData(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
