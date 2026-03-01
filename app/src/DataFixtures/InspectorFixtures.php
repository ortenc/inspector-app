<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Inspector;
use App\Enum\InspectorLocation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class InspectorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getSampleData() as $data) {
            $inspector = new Inspector()
                ->setName($data['name'])
                ->setLocation($data['location']);

            $manager->persist($inspector);
        }

        $manager->flush();
    }

    private function getSampleData(): array
    {
        return [
            [
                'name' => 'Tommy',
                'location' => InspectorLocation::LONDON->value,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'Patrick',
                'location' => InspectorLocation::MEXICO->value,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'Jackson',
                'location' => InspectorLocation::AUSTRALIA->value,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'Benn',
                'location' => InspectorLocation::INDIA->value,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'Ann',
                'location' => InspectorLocation::NEW_YORK->value,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];
    }
}
