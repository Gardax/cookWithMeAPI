<?php
/**
 * Created by PhpStorm.
 * User: dahaka
 * Date: 12/4/15
 * Time: 6:41 PM
 */

namespace CookWithMeBundle\Controller;

use CookWithMeBundle\Models\UserModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserController
 * @package CookWithMeBundle\Controller
 */
class UserController extends Controller
{
    const SUCCESS = 1;
    const FAIL = 0;

    /**
     * @Route("/add/user" , name="addUser")
     * @Method({"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addUserAction(Request $request){

        $userService = $this->get('user_service');

        try {
            $userData = [
                'username' => $request->request->get('username'),
                'email' => $request->request->get('email'),
                'password' => $request->request->get('password')
            ];

            $userEntity = $userService->addUser($userData);
            $userModel = new UserModel($userEntity);

            return new JsonResponse($userModel);

        }catch (\Exception $ex){
            return new JsonResponse([
                "error" => $ex->getMessage(),
                "success" => self::FAIL
            ]);
        }
    }
}