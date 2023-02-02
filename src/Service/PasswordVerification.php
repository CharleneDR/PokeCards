<?php

namespace App\Service;

class PasswordVerification
{
    private array $errors = [];

    public function verifyPassword(string $password, string $password2): array
    {
        $upperCase = preg_match('/[A-Z]/', $password);
        $lowerCase = preg_match('/[a-z]/', $password);
        $number = preg_match('/[0-9]/', $password);
        $specialCharacter = preg_match('/[^\w\s]|_/', $password);

        if (strlen($password) < 8) {
            $this->errors[] = "Your password should be at least 8 characters";
        }

        if (!$upperCase) {
            $this->errors[] = "Your password should contain at least 1 uppercase character";
        }


        if (!$number) {
            $this->errors[] = "Your password should contain at least 1 number";
        }

        if (!$specialCharacter) {
            $this->errors[] = "Your password should contain at least 1 special character";
        }

        if (empty($password)) {
            $this->errors[] = "Your password is mandatory";
        }

        if ($password != $password2) {
            $this->errors[] = "Your passwords should be similar";
        }

        return $this->errors;
    }
}