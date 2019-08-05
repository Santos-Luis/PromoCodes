<?php

namespace App\Controller\API;

use App\Entity\PromoCode;
use App\Repository\PromoCodeRepository;
use DateTime;
use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidatorController extends AbstractController
{
    /**
     * @Rest\Get("/validate/{promoCodeId}", name="validate_promo_code_api")
     *
     * @param string              $promoCodeId
     * @param PromoCodeRepository $repository
     * @param Request             $request
     *
     * @return Response
     *
     * @throws Exception
     */
    public function validatePromoCode(
        string $promoCodeId,
        PromoCodeRepository $repository,
        Request $request
    ): Response {
        $userId = $request->get('user-id');
        if (!$userId) {
            return new Response('Error: missing user-id query parameter', 500);
        }

        $promoCode = $repository->getById($promoCodeId);
        if (!$promoCode instanceof PromoCode) {
            return new Response('Error: invalid promo code id', 500);
        }

        if ($promoCode->getOwner() === $userId) {
            return new Response('Error: user cannot user own promo code', 500);
        }

        if ($promoCode->getExpirationDate() < new DateTime()) {
            return new Response('Error: promo code already expired', 500);
        }

        return new Response('Valid promo code', 200);
    }
}
