<?php

namespace App\Controller\API;

use App\Entity\PromoCode;
use App\Repository\PromoCodeRepository;
use DateInterval;
use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreatorController extends AbstractController
{
    private const DEFAULT_DISCOUNT_PERCENTAGE = 10;
    private const DEFAULT_EXPIRATION_DAYS = 'P15D';
    private const UUID_LENGTH = 8;

    /**
     * @Rest\Post("/create/{owner}", name="create_promo_code_api")
     *
     * @param PromoCodeRepository $repository
     * @param Request             $request
     *
     * @param string              $owner
     * @return JsonResponse
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createPromoCode(PromoCodeRepository $repository, Request $request, string $owner): JsonResponse
    {
        $id = $this->generateUUID();
        $discountPercentage = $request->get('discount-percentage', self::DEFAULT_DISCOUNT_PERCENTAGE);
        $createdBy = $this->getUser()->getUsername();

        $expirationDate = $request->get('expiration-date');
        $expirationDate = $expirationDate
            ? new DateTime($expirationDate)
            : (new DateTime())->add(new DateInterval(self::DEFAULT_EXPIRATION_DAYS));

        $promoCode = new PromoCode($id, $owner, $discountPercentage, $expirationDate, $createdBy);
        $repository->save($promoCode);

        return new JsonResponse(['promo_code_id' => $promoCode->getId()], 201);
    }

    private function generateUUID(): string
    {
        $random = '';
        for ($i = 0; $i < self::UUID_LENGTH; $i++) {
            $random .= random_int(0, 1) ? random_int(0, 9) : chr(random_int(ord('a'), ord('z')));
        }

        return $random;
    }
}
