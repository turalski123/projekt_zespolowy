<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueField extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Field "{{ fieldName }}" for "{{ entityClass }}" must be unique';

    /**
     * @var string
     */
    public $fieldName;

    /**
     * @var string
     */
    public $entityClass;
}
