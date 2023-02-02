<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
        {
            $sacha = new User();
            $sacha->setUsername('SachaDuBourgPalette');
            $sacha->setEmail('sacha@gmail.com');
            $sacha->setCountry('JP');
            $sacha->setRoles(['ROLE_COLLECTOR']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $sacha,
                'sacha.123'
            );
            $sacha->setPassword($hashedPassword);
            $sacha->setIsVerified(true);
            $manager->persist($sacha);

            $timothee = new User();
            $timothee->setUsername('TimDu69');
            $timothee->setEmail('timothee@gmail.com');
            $timothee->setCountry('FR');
            $timothee->setRoles(['ROLE_COLLECTOR']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $timothee,
                'timothee.123'
            );
            $timothee->setPassword($hashedPassword);
            $timothee->setIsVerified(true);
            $manager->persist($timothee);
    
            $admin = new User();
            $admin->setUsername('admin');
            $admin->setEmail('admin@pokecards.com');
            $admin->setCountry('FR');
            $admin->setRoles(['ROLE_ADMIN', 'ROLE_COLLECTOR']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $admin,
                'admin.123'
            );
            $admin->setPassword($hashedPassword);
            $admin->setIsVerified(true);
            $manager->persist($admin);
    
            $manager->flush();
    }
}
