<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\OpenApi\Model\Operation as OpenApiOperation;
use ApiPlatform\OpenApi\Model\RequestBody;
use App\Controller\Rest\ApiInspectorController;
use App\Repository\InspectorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InspectorRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Patch(),
        new Delete(),
        new Post(
            uriTemplate: '/inspectors/{id}/job',
            controller: ApiInspectorController::class . '::assignJob',
            name: 'assign_job',
            openapi: new OpenApiOperation(
                summary: 'Assign a job to an inspector',
                requestBody: new RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'jobId' => ['type' => 'integer', 'example' => 5],
                                    'assignedDate' => ['type' => 'string', 'format' => 'date', 'example' => '2000-01-23'],
                                ],
                            ],
                        ],
                    ])
                ),
            ),
            read: false,
            deserialize: false,
        ),
        new Put(
            uriTemplate: '/inspectors/{id}/job/start/{jobId}',
            controller: ApiInspectorController::class . '::startJob',
            name: 'start_job',
            openapi: new OpenApiOperation(
                summary: 'Start a job for an inspector',
            ),
            read: false,
            deserialize: false,
        ),
        new Put(
            uriTemplate: '/inspectors/{id}/job/complete/{jobId}',
            controller: ApiInspectorController::class . '::completeJob',
            name: 'complete_job',
            openapi: new OpenApiOperation(
                summary: 'Complete a job for an inspector',
            ),
            read: false,
            deserialize: false,
        ),
    ]
)]
class Inspector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }
}
