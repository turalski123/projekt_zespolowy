<?php


namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \Exception
{
    /**
     * @var ConstraintViolationListInterface
     */
    private ConstraintViolationListInterface $violationList;

    /**
     * ValidationException constructor.
     * @param ConstraintViolationListInterface $violationList
     */
    public function __construct(ConstraintViolationListInterface $violationList)
    {
        $this->violationList = $violationList;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }
}
