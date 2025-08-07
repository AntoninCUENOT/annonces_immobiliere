<?php

namespace Models;

require_once __DIR__ . '/../database/Database.php';

use Config\Database\Database;
use PDO;

class LoginModel
{
    private string $email;
    private string $password;
    private ?PDO $db;

    public function __construct(array $postData)
    {
        $this->email = $postData['email'] ?? '';
        $this->password = $postData['password'] ?? '';
        $this->db = Database::getConnection();
    }

    public function isValid(): bool
    {
        if (empty($this->email) || empty($this->password)) {
            return false;
        }

        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($this->password, $user['password'])) {
            $_SESSION['user'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return true;
        }

        return false;
    }

    public function getData(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
