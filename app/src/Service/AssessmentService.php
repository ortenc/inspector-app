<?php

namespace App\Service;

use App\Dto\Request\AssignJobRequest;
use App\Entity\Assessment;
use App\Entity\Inspector;
use App\Enum\InspectorLocation;
use App\Enum\JobStatus;
use App\Repository\AssessmentRepository;
use App\Repository\JobRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class AssessmentService
{
    public function __construct(
        private AssessmentRepository $assessmentRepository,
        private JobRepository        $jobRepository,
        private LoggerInterface      $logger,
    )
    {
    }

    public function assignJob(
        Inspector $inspector,
        AssignJobRequest $request,
    ): Assessment {
        $this->logger->info(
            sprintf(
                "Start process to assign a new job to inspector with id %s.",
                $inspector->getId(),
            ),
        );
        $assessment = new Assessment();
        $job = $this->jobRepository->find($request->jobId);

        if (!$job) {
            throw new NotFoundHttpException('Job not found for id '. $request->jobId .'.');
        }

        if ($job->getStatus() === JobStatus::ASSIGNED->value) {
            throw new NotFoundHttpException('Job with id '. $request->jobId .' is assigned already.');
        }

        $timezone = $this->setTimezone($inspector, $request->assignedDate);
        $assessment
            ->setInspector($inspector)
            ->setJob($job)
            ->setAssignedDate($timezone)
            ->setStatus(JobStatus::IN_PROGRESS);
        $assessment->getJob()->setStatus(JobStatus::IN_PROGRESS);

        $this->assessmentRepository->save($assessment, true);

        $job->setStatus(JobStatus::ASSIGNED);
        $this->jobRepository->save($job, true);

        return $assessment;
    }

    public function startJob(
        Assessment $assessment,
    ): void {
        $this->logger->info(
            sprintf(
                "Start process to start a job from inspector with id %s.",
                $assessment->getInspector()->getId(),
            ),
        );

        $assessment->getJob()->setStatus(JobStatus::IN_PROGRESS);
        $assessment->setStatus(JobStatus::IN_PROGRESS);
        $this->assessmentRepository->save($assessment, true);
    }

    public function completeJob(
        Assessment $assessment,
    ): void {
        $this->logger->info(
            sprintf(
                "Start process to complete a job from inspector with id %s.",
                $assessment->getInspector()->getId(),
            ),
        );
        $assessment->getJob()->setStatus(JobStatus::COMPLETED);
        $assessment
            ->setStatus(JobStatus::COMPLETED);
        $this->assessmentRepository->save($assessment, true);
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \DateInvalidTimeZoneException
     */
    private function setTimezone(
        Inspector $inspector,
        \DateTime $currentTime
    ): \DateTime
    {
        $location = $inspector->getLocation();
        $dateTime = match($location) {
            InspectorLocation::LONDON->value => $currentTime->setTimezone(new \DateTimeZone(InspectorLocation::LONDON->value)),
            InspectorLocation::INDIA->value => $currentTime->setTimezone(new \DateTimeZone(InspectorLocation::INDIA->value)),
            InspectorLocation::MEXICO->value => $currentTime->setTimezone(new \DateTimeZone(InspectorLocation::MEXICO->value)),
            InspectorLocation::AUSTRALIA->value => $currentTime->setTimezone(new \DateTimeZone(InspectorLocation::AUSTRALIA->value)),
            InspectorLocation::NEW_YORK->value => $currentTime->setTimezone(new \DateTimeZone(InspectorLocation::NEW_YORK->value)),
            default => $currentTime,
        };

        $dateTime->format('Y-m-d H:i:s');

        return $dateTime;
    }
}
