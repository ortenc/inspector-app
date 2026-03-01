<?php

declare(strict_types=1);

namespace App\Dto\Response;

use DateTimeInterface;
use OpenApi\Attributes as OA;

class AssessmentResponse
{
    #[OA\Property(example: 3)]
    private int $id;

    #[OA\Property(example: [['id' => 5, 'name' => 'Jackson', 'location' => 'UK']])]
    private InspectorResponse $inspector;

    #[OA\Property(example: [['id' => 3, 'description' => 'Some work description', 'status' => 'new']])]
    private JobResponse $job;

    #[OA\Property(example: '2000-01-23')]
    private DateTimeInterface $assignedDate;

    public function __construct(
        int $id,
        InspectorResponse $inspector,
        JobResponse $job,
        DateTimeInterface $assignedDate,
    ) {
        $this->id = $id;
        $this->inspector = $inspector;
        $this->job = $job;
        $this->assignedDate = $assignedDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInspector(): InspectorResponse
    {
        return $this->inspector;
    }

    public function getJob(): JobResponse
    {
        return $this->job;
    }

    public function getAssignedDate(): DateTimeInterface
    {
        return $this->assignedDate;
    }
}
