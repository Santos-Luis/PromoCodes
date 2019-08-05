<?php

namespace App\Controller\API;

use App\Entity\PromoCode;
use App\Repository\PromoCodeRepository;
use DateTime;
use DateTimeZone;
use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class EditorController extends AbstractController
{
    /**
     * @Rest\Patch("/edit", name="edit_promo_code_api")
     *
     * @param PromoCodeRepository $repository
     * @param Request             $request
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function editPromoCode(PromoCodeRepository $repository, Request $request): JsonResponse
    {
        /**
        $authToken = $request->get('token');
        if (null === $authToken) {
            return new JsonResponse('Authentication error', 500);
        }
         **/

        $id = $request->get('promo-code-id');
        if (null === $id) {
            return new JsonResponse('Missing promo-code-id query parameter', 500);
        }

        $promoCode = $repository->getById($id);
        if (null === $promoCode) {
            return new JsonResponse('Invalid promo code', 500);
        }

        $newOwner = $request->get('owner');
        if (null !== $newOwner) {
            $promoCode->setOwner($newOwner);
        }

        $newDiscountPercentage = $request->get('discount-percentage');
        if (null !== $newDiscountPercentage) {
            $promoCode->setDiscountPercentage($newDiscountPercentage);
        }

        $newExpirationDate = $request->get('expiration-date');
        if (null !== $newExpirationDate) {
            $promoCode->setExpirationDate($newExpirationDate);
        }

        $newCreatedBy = $request->get('created-by');
        if (null !== $newCreatedBy) {
            $promoCode->setCreatedBy($newCreatedBy);
        }

        $promoCode->setEditedAt(new DateTime('now', new DateTimeZone('Europe/Lisbon')));

        $repository->save($promoCode);

        return new JsonResponse('Promo code ' . $id . ' successfully edited', 200);
    }
}
