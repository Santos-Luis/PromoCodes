<?php

namespace App\Controller\API;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TokenController extends AbstractController
{
    /**
     * @Rest\Post("/tokens/new", name="new_token_api)
     *
     */
    public function newToken()
    {

    }
}
