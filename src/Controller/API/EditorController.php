<?php

namespace App\Controller\API;

use App\Repository\PromoCodeRepository;
use DateTime;
use DateTimeZone;
use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditorController extends AbstractController
{
    /**
     * @Rest\Patch("/edit/{promoCodeId}", name="edit_promo_code_api")
     *
     * @param string              $promoCodeId
     * @param PromoCodeRepository $repository
     * @param Request             $request
     *
     * @return Response
     *
     * @throws Exception
     */
    public function editPromoCode(
        string $promoCodeId,
        PromoCodeRepository $repository,
        Request $request
    ): Response {
        $promoCode = $repository->getById($promoCodeId);
        if (!$promoCode) {
            return new Response('Error: invalid promo code', 500);
        }

        $newOwner = $request->get('owner');
        if ($newOwner) {
            $promoCode->setOwner($newOwner);
        }

        $newDiscountPercentage = $request->get('discount-percentage');
        if ($newDiscountPercentage) {
            $promoCode->setDiscountPercentage($newDiscountPercentage);
        }

        $newExpirationDate = $request->get('expiration-date');
        if ($newExpirationDate) {
            $promoCode->setExpirationDate(new DateTime($newExpirationDate));
        }

        $newCreatedBy = $request->get('created-by');
        if ($newCreatedBy) {
            $promoCode->setCreatedBy($newCreatedBy);
        }

        $promoCode->setEditedAt(new DateTime('now', new DateTimeZone('Europe/Lisbon')));

        $repository->save($promoCode);

        return new Response('Promo code ' . $promoCodeId . ' successfully edited', 200);
    }
}
