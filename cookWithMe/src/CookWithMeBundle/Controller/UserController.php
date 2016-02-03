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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserController
 * @package CookWithMeBundle\Controller
 */
class UserController extends Controller
{
    const SUCCESS = 1;
    const FAIL = 0;

    /**
     * @Route("/user/add" , name="addUser")
     * @Method({"POST"})
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

    /**
     * @Route("/user/single/{id}", name="getUser")
     * @Method({"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function getUserAction($id){

        try {
            $userService = $this->get('user_service');

            $userEntity = $userService->getUserById($id);

            $userModel = new UserModel($userEntity);

            return new JsonResponse($userModel);
        }catch (\Exception $ex) {
            return new JsonResponse([
                "error" => $ex->getMessage(),
                "success" => self::FAIL
            ]);
        }
    }

    /**
     * @Route("/user/authenticate" , name="authenticate")
     * @Method({"POST"})
     */
    public function authenticateAction(Request $request){

        $userService = $this->get('user_service');

        try {
            $userData = [
                'username' => $request->request->get('username'),
                'email' => $request->request->get('email'),
                'password' => $request->request->get('password')
            ];

            $success = $userService->authenticate($userData);


            return new JsonResponse([]);

        }catch (\Exception $ex){
            return new JsonResponse([
                "error" => $ex->getMessage(),
                "success" => self::FAIL
            ]);
        }
    }
}