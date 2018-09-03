<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use App\Entity\Student;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Carbon\Carbon;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create teacher
        $date = new Carbon('1995-11-28');

        for ($i = 1; $i <= 10; $i++) {
            $teacher = new Teacher();
            $teacher->setFullname('Teacher '.$i);
            $teacher->setDateofbirth($date);
            $teacher->setPosition('teacher');
            $manager->persist($teacher);
        }

        for ($i = 1; $i <= 10; $i++) {
            $student = new Student();
            $student->setFullname('Student '.$i);
            $student->setDateofbirth($date);
            $manager->persist($student);
        }

        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@gmail.com');
        $user->setPassword('123456');
        $manager->persist($user);

        $manager->flush();
    }
}