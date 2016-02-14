<?php

namespace CookWithMeBundle\Controller;

use CookWithMeBundle\Entity\User;
use CookWithMeBundle\Exceptions\InvalidFormException;
use CookWithMeBundle\Models\UserModel;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use CookWithMeBundle\Form\Type\UserType;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class UserController extends Controller
{
    /**
     * @Route("/user/add" , name="addUser")
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @throws InvalidFormException
     * @return JsonResponse
     */
    public function registerAction(Request $request) {
        //TODO: Check if the username and the emails are free.

        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['validation_groups' => ['registration']] );
        $form->handleRequest($request);

        if(!$form->isValid()){
            throw new InvalidFormException($form);
        }

        $userService = $this->get('user_service');

        $user = $userService->addUser($user);

        $userModel = new UserModel($user);

        return new JsonResponse($userModel);
    }

    /**
     * @Route("/user/authenticate" , name="authenticateUser")
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @throws InvalidFormException
     * @return JsonResponse
     */
    public function authenticateAction(Request $request) {
        $userData = $request->get('userData');
        $username = $userData['username'];
        $password = $userData['password'];

        $userService = $this->get('user_service');
        $user = $userService->authenticateUser($username, $password);

        $userModel = new UserModel($user);

        return new JsonResponse($userModel);
    }
}
