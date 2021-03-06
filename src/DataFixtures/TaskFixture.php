<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TaskFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $task1 = new Task('Vysypat koš v pondělí');
        $task2 = new Task('Vyzvednout balíček');

        $manager->persist($task1);
        $manager->persist($task2);

        for ($i = 0; $i < 100; $i++) {
            $task = new Task($faker->sentence(5));

            $manager->persist($task);
        }

        $manager->flush();
    }
}
