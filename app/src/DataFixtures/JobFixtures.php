<?php

namespace App\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Job;
use App\Enum\JobStatus;

class JobFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getSampleData() as $data) {
            $job = (new Job())
                ->setName($data['name'])
                ->setStatus($data['status'])
                ->setDescription($data['description'])
                ->setCreatedAt($data['created_at'])
                ->setUpdatedAt($data['updated_at']);

            $manager->persist($job);
        }

        $manager->flush();
    }

    private function getSampleData(): array
    {
        return [
            [
                'name' => 'test1',
                'description' => 'Develop new features for user-centric mobile application.',
                'status' => JobStatus::ASSIGNED,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'test1',
                'description' => 'Design modern, responsive layouts for digital platforms.',
                'status' => JobStatus::NEW,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'test1',
                'description' => 'Direct customer service with a focus on satisfaction.',
                'status' => JobStatus::ASSIGNED,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'test1',
                'description' => 'Oversee regional sales team performance metric.',
                'status' => JobStatus::NEW,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'test1',
                'description' => 'Maintain company social media presence and engagement.',
                'status' => JobStatus::NEW,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];
    }
}
