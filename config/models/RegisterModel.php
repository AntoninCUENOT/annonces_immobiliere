<?php
namespace Models;

class RegisterModel
{
    private string $email;
    private string $password;
    private string $confirmPassword;

    public function __construct(array $postData)
    {
        $this->email = $postData['email'] ?? '';
        $this->password = $postData['password'] ?? '';
        $this->confirmPassword = $postData['confirm_password'] ?? '';
    }

    public function isValid(): bool
    {
        return !empty($this->email) && !empty($this->password) && $this->password === $this->confirmPassword;
    }

    public function getData(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
