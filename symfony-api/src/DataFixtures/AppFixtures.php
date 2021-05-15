<?php

namespace App\DataFixtures;

use App\Entity\ApiUsers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $apiUser1 = new ApiUsers();
        $apiUser1->setName('Bruno')
            ->setEmail('bruno@bruno.com')
            ->setPassword('pass')
            ->setCity('Berlin')
        ;

        $apiUser2 = new ApiUsers();
        $apiUser2->setName('Admin')
            ->setEmail('admin@admin.io')
            ->setPassword('pass')
            ->setCity('Berlin')
        ;

        $manager->persist($apiUser1);
        $manager->persist($apiUser2);

        $manager->flush();
    }
}
