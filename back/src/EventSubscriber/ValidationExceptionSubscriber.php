<?php

namespace App\EventSubscriber;

use App\Exception\ValidationException;
use App\SharedKernel\Infrastructure\Exception\IApiValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolation;

class ValidationExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof ValidationException) {
            return;
        }

        $errorsData = [];
        /**
         * @var int $index
         * @var ConstraintViolation $violation
         */
        foreach ($exception->getViolations() as $index => $violation) {
            if ($violation->getConstraint() instanceof Collection) {
                continue;
            }

            $errorsData []= [
                'source' => $violation->getPropertyPath(),
                'message' => $violation->getMessage()
            ];
        }

        $event->setResponse(new JsonResponse(
            [
                'errors' => $errorsData
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        ));
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
