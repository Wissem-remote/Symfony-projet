<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class UserFixture extends Fixture  implements FixtureGroupInterface
{
    private $hash;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hash= $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $admin = new User;
        $admin->setEmail('admin@admin.com');
        $admin->setPassword($this->hash->hashPassword($admin,'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
