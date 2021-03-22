<?php

namespace App\Validator;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueFieldValidator extends ConstraintValidator
{
    /**
     * @var DocumentManager
     */
    private DocumentManager $documentManager;

    public function __construct(
        DocumentManager $documentManager
    )
    {
        $this->documentManager = $documentManager;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\UniqueField */

        if (null === $value || '' === $value) {
            return;
        }

        if (
            null === $this->documentManager->getRepository($constraint->entityClass)->findOneBy(
                [$constraint->fieldName => $value]
            )
        ) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->setParameter('{{ fieldName }}', $constraint->fieldName)
            ->setParameter('{{ entityClass }}', $constraint->entityClass)
            ->addViolation();
    }
}
