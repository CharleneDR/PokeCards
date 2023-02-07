<?php

namespace App\Tests\Service;

use App\Service\PasswordVerification;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PasswordVerificationTest extends KernelTestCase
{
    public function getPasswordData(): array
    {
        return [
            ["", "", [
                "Your password should be at least 8 characters",
                "Your password should contain at least 1 uppercase character",
                "Your password should contain at least 1 number",
                "Your password should contain at least 1 special character",
                "Your password is mandatory"
            ]],
            ["azerty123", "azerty123", [
                "Your password should contain at least 1 uppercase character",
                "Your password should contain at least 1 special character"
                ]],
            ["Azerty.123", "Azerty.123", []],
            ["Azerty.123", "Azerty123", ["Your passwords should be similar"]],
            ["Azertyyy", "Azertyyy", [
                "Your password should contain at least 1 number",
                "Your password should contain at least 1 special character"
                ]],
            ["a123", "a123", [
                "Your password should be at least 8 characters",
                "Your password should contain at least 1 uppercase character",
                "Your password should contain at least 1 special character"
            ]]
        ];
    }

    /**
     * @dataProvider getPasswordData
     */
    public function testverifyPassword(string $password1, string $password2, array $result): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();
        $passwordVerification = $container->get(PasswordVerification::class);

        $this->assertSame($result, $passwordVerification->verifyPassword($password1, $password2));
    }
}