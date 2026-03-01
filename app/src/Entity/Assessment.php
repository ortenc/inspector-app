<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\JobStatus;
use App\Repository\AssessmentRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssessmentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Assessment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Inspector $inspector;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Job $job;

    #[ORM\Column(length: 255, nullable: false, enumType: JobStatus::class)]
    private JobStatus $status;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private \DateTimeInterface $assigned_date;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInspector(): Inspector
    {
        return $this->inspector;
    }

    public function setInspector(Inspector $inspector): static
    {
        $this->inspector = $inspector;

        return $this;
    }

    public function getJob(): Job
    {
        return $this->job;
    }

    public function setJob(Job $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status->value;
    }

    public function setStatus(JobStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAssignedDate(): \DateTimeInterface
    {
        return $this->assigned_date;
    }

    public function setAssignedDate(\DateTimeInterface $assigned_date): static
    {
        $this->assigned_date = $assigned_date;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist()]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable('now');
        $this->updatedAt = new \DateTimeImmutable('now');
    }

    #[ORM\PreUpdate()]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable('now');
    }
}
