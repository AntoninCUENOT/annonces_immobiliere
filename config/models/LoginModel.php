<?php

namespace Models;

class LoginModel
{
    private string $email;
    private string $password;

    public function __construct(array $postData)
    {
        $this->email = $postData['email'] ?? '';
        $this->password = $postData['password'] ?? '';
    }

    public function isValid(): bool
    {
        if ($this->email === 'admin@admin' && $this->password === 'admin') {
            $_SESSION['mail'] = $this->email;
            return !empty($this->email) && !empty($this->password);
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
