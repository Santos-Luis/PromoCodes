<?php

namespace App\Controller\API;

use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class TokenController extends AbstractController
{
    /**
     * @Rest\Post("/tokens/new", name="new_token_api")
     *
     * @param JWTEncoderInterface          $encoder
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository               $repository
     *
     * @return JsonResponse
     *
     * @throws JWTEncodeFailureException
     */
    public function newToken(
        JWTEncoderInterface $encoder,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $repository
    ): JsonResponse {
        $username = $request->get('username');
        if (!$username) {
            return new JsonResponse('Error: missing username query parameter');
        }

        $password = $request->get('password');
        if (!$password) {
            return new JsonResponse('Error: missing password query parameter');
        }

        $user = $repository->getByUsername($username);
        if (!$user) {
            throw new BadCredentialsException('Wrong credentials');
        }

        $isValid = $passwordEncoder->isPasswordValid($user, $password);
        if (!$isValid) {
            throw new BadCredentialsException('Wrong credentials');
        }

        $token = $encoder->encode(['username' => $user->getUsername(), 'exp' => time() + 3600]);

        return new JsonResponse(['token' => $token]);
    }
}
