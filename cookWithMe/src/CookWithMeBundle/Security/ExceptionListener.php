<?php
namespace CookWithMeBundle\Security;

use CookWithMeBundle\Exceptions\InvalidFormException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $response = new JsonResponse([
            'errorMessage'=>$event->getException()->getMessage(),
            'stackTrace' => $event->getException()->getTraceAsString()
        ]);


        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
        }
        else if($exception instanceof AuthenticationException){
            $response->setData(['errorMessage'=>'You don\'t have permissions to do this.']);
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
        }
        else if ($exception instanceof InvalidFormException ){
            $errors = [];
            foreach ($exception->getForm()->getErrors(true) as $error) {
                if ($error->getOrigin()) {
                    $errors[$error->getOrigin()->getName()][] = $error->getMessage();
                }
            }
            $data = [
                'errors' => $errors,
                'errorMessage' => '',
            ];
            $response->setData($data);
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}