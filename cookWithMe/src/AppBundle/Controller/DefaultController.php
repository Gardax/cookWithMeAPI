<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/{path}", name="error", requirements={"path"=".+"})
     */
    public function indexAction(Request $request, $path)
    {
        return new JsonResponse(['error'=>'No route found for path: ' . $path]);
    }

}
