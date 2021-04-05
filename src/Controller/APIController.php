<?php

declare(strict_types=1);

namespace App\Controller;

use App\DataProvider\VacanciesProviderInterface;
use App\Entity\Vacancy;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @OA\Tag(name="Vacancies")
 * @Route("/vacancy")
 */
class APIController
{
    private SerializerInterface $serializer;
    private VacanciesProviderInterface $provider;

    public function __construct(SerializerInterface $serializer, VacanciesProviderInterface $provider)
    {
        $this->serializer = $serializer;
        $this->provider = $provider;
    }

    /**
     * @Route("", methods={"GET"})
     * @OA\Get(
     *     description="Receive available vacancies",
     *     summary="Receive available vacancies",
     *     @OA\Parameter(
     *          name="country",
     *          in="query",
     *          schema=@OA\Schema(type="string"),
     *          description="Filter by country",
     *     ),
     *     @OA\Parameter(
     *          name="city",
     *          in="query",
     *          schema=@OA\Schema(type="string"),
     *          description="Filter by city",
     *     ),
     *     @OA\Parameter(
     *          name="order_by",
     *          in="query",
     *          schema=@OA\Schema(type="string"),
     *          description="Order by",
     *     ),
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns available vacancies",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Vacancy::class))
     *     )
     * )
     */
    public function vacancies(Request $request): JsonResponse
    {
        $data = $this->provider->getByFilters($request->query->all());

        return new JsonResponse(
            $this->serializer->serialize($data, 'json'),
            Response::HTTP_OK,
            [],
            true,
        );
    }

    /**
     * @Route("/{id}", requirements={"id" = "\d+"}, methods={"GET"})
     * @OA\Get(
     *     description="Receive vacancy by id",
     *     summary="Receive vacancy by id",
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns vacancy",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Vacancy::class))
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description="Not found",
     * )
     */
    public function getById(int $id): JsonResponse
    {
        $vacancy = $this->provider->getById($id);

        if ($vacancy === null) {
            throw new NotFoundHttpException('Requested vacancy not found');
        }

        return new JsonResponse(
            $this->serializer->serialize($vacancy, 'json'),
            Response::HTTP_OK,
            [],
            true,
        );
    }

    /**
     * @Route("/serach-interesting", methods={"GET"})
     * @OA\Get(
     *     description="Receive vacancy by skills",
     *     summary="Receive interesting vacancy by skills",
     *     @OA\Parameter(
     *          name="skills[]",
     *          in="query",
     *          schema=@OA\Schema(type="array", @OA\Items(type="string")),
     *          description="Skills array",
     *     ),
     * ),
     * @OA\Response(
     *     response=404,
     *     description="Not found",
     * )
     */
    public function findInteresting(Request $request): JsonResponse
    {
        $skills = $request->get('skills', []);

        $vacancy = $this->provider->getVacancyBySkillSet($skills);

        if ($vacancy === null) {
            throw new NotFoundHttpException('There is no vacancy with your skill set');
        }

        return new JsonResponse(
            $this->serializer->serialize($vacancy, 'json'),
            Response::HTTP_OK,
            [],
            true,
        );
    }
}
