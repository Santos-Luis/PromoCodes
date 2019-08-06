<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractFOSRestController
{
    /**
     * @Rest\POST("/register/user", name="register_user_api")
     *
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository               $userRepository
     *
     * @return View
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function registerUser(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $userRepository
    ): View {
        $username = $request->get('username');
        if (!$username) {
            return $this->view([
                'message' => 'Missing username query parameter',
            ], Response::HTTP_BAD_REQUEST);
        }

        $password = $request->get('password');
        if (!$password) {
            return $this->view([
                'message' => 'Missing password query parameter',
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $userRepository->getByUsername($username);
        if ($user) {
            return $this->view([
               'message' => 'User already exists',
            ], Response::HTTP_CONFLICT);
        }

        $roles = json_decode($request->get('roles'), true);
        if (!$roles) {
            $roles = ['ROLE_USER'];
        }

        $user = new User();
        $user->setUsername($username);
        $user->setRoles($roles);
        $user->setPassword($passwordEncoder->encodePassword($user, $password));
        $userRepository->save($user);

        return $this->view($user, Response::HTTP_CREATED)->setContext((new Context())->setGroups(['public']));
    }
}
