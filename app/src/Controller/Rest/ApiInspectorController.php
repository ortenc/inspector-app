<?php

namespace App\Controller\Rest;

use App\Dto\Request\AssignJobRequest;
use App\Entity\Inspector;
use App\Entity\Job;
use App\Repository\AssessmentRepository;
use App\Service\AssessmentService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\PathItem(path: '/api/inspectors')]
final class ApiInspectorController extends AbstractController
{
    public function __construct(
        private readonly AssessmentRepository $assessmentRepository,
        private readonly AssessmentService $assessmentService,
    ) {
    }
    #[OA\Tag]
    #[Route('/api/inspectors/{id}/job', name: 'app_api_inspector_assign_job', methods: ['POST'])]

    public function assignJob(
        Inspector $inspector,
        #[MapRequestPayload] AssignJobRequest $request
    ): JsonResponse {
        $assignment = $this->assessmentService->assignJob($inspector, $request);
        return $this->json($assignment);
    }

    #[Route('/api/inspectors/{id}/job/start/{jobId}', name: 'app_api_inspector_start_job', methods: ['PUT'])]
    public function startJob(
        Inspector $inspector,
        #[MapEntity(id: 'jobId')] Job $job,
    ): Response {
        $assessment = $this->assessmentRepository->findOneBy(
            ['inspector' => $inspector->getId(), 'job' => $job->getId()],
        );
        if (!$assessment) {
            throw new NotFoundHttpException('No inspector is assigned to job with id ' . $job->getId());
        }
        $this->assessmentService->startJob($assessment);
        return $this->json(['message' => 'Job started!']);
    }

    #[Route('/api/inspectors/{id}/job/complete/{jobId}', name: 'app_api_inspector_complete_job', methods: ['PUT'])]
    public function completeJob(
        Inspector $inspector,
        #[MapEntity(id: 'jobId')] Job $job,
    ): Response {
        $assessment = $this->assessmentRepository->findOneBy(
            ['inspector' => $inspector->getId(), 'job' => $job->getId()],
        );
        if (!$assessment) {
            throw new NotFoundHttpException('No inspector is assigned to job with id ' . $job->getId());
        }
        $this->assessmentService->completeJob($assessment);
        return $this->json(['message' => 'Job completed!']);
    }
}
