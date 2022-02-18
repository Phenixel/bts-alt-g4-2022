<?php

namespace App\DataFixtures;

// src/DataFixtures/AppFixtures.php
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    // ...
    public function load(ObjectManager $manager)
    {
        $tabAdmin = ['phen@gsb.fr','max@gsb.fr'];

        foreach ($tabAdmin as $mail){
            $user = new User();
            $user->setEmail($mail);

//            Ajout de rôle
            $user->setRoles(["ROLE_ADMIN"]);

            $password = $this->hasher->hashPassword($user, 'azerty');
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();
        }

        $tabuser = ['user@gsb.fr','lambda@gsb.fr'];

        foreach ($tabuser as $mail){
            $user = new User();
            $user->setEmail($mail);

//            Ajout de rôle
            $user->setRoles(["ROLE_USER"]);

            $password = $this->hasher->hashPassword($user, 'azerty');
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();
        }
    }
}
