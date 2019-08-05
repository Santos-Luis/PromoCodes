<?php

namespace App\Controller\API;

use App\Entity\PromoCode;
use App\Repository\PromoCodeRepository;
use DateInterval;
use DateTime;
use Exception;
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
     * @Rest\Post("/new", name="new_promo_code_api")
     *
     * @param PromoCodeRepository $repository
     * @param Request             $request
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function createPromoCode(PromoCodeRepository $repository, Request $request): JsonResponse
    {
        $owner = $request->get('owner');
        if (null === $owner) {
            return new JsonResponse('Missing owner query parameter', 500);
        }

        $id = $this->generateUUID();
        $discountPercentage = $request->get('discount-percentage', self::DEFAULT_DISCOUNT_PERCENTAGE);
        $createdBy = $request->get('created-by', 'uniplaces');

        $expirationDate = $request->get('expiration-date');
        if (null === $expirationDate) {
            $now = new DateTime();
            $expirationDate = $now->add(new DateInterval(self::DEFAULT_EXPIRATION_DAYS));
        }

        $promoCode = new PromoCode($id, $owner, $discountPercentage, $expirationDate, $createdBy);
        $repository->save($promoCode);

        return new JsonResponse($promoCode->getId(), 200);
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