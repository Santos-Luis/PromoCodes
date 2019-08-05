<?php

namespace App\Controller\API;

use App\Entity\PromoCode;
use App\Repository\PromoCodeRepository;
use DateTime;
use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ValidatorController extends AbstractController
{
    /**
     * @Rest\Get("/validate", name="validate_promo_code_api")
     *
     * @param PromoCodeRepository $repository
     * @param Request             $request
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function validatePromoCode(PromoCodeRepository $repository, Request $request): JsonResponse
    {
        $id = $request->get('promo-code-id');
        if (null === $id) {
            return new JsonResponse('Missing promo-code-id query parameter', 500);
        }

        $userId = $request->get('user-id');
        if (null === $userId) {
            return new JsonResponse('Missing user-id query parameter', 500);
        }

        $promoCode = $repository->getById($id);
        if (!$promoCode instanceof PromoCode) {
            return new JsonResponse('Invalid promo code id', 500);
        }

        if ($promoCode->getOwner() === $userId) {
            return new JsonResponse('User cannot user own promo code', 500);
        }

        if ($promoCode->getExpirationDate() < new DateTime()) {
            return new JsonResponse('Promo code already expired', 500);
        }

        return new JsonResponse('Valid promo code', 200);
    }
}
