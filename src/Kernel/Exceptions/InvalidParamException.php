<?php

namespace Mundipagg\Core\Kernel\Exceptions;

/**
 * The InvalidParamException. It should be thrown when an business rule validation
 * fails inside an Aggregate or Value Object setter.
 */
class InvalidParamException extends AbstractMundipaggCoreException
{
    /**
     * InvalidParamException constructor.
     * Combines the exception message with the actual value passed.
     *
     * @param string $message The exception message.
     * @param string $value   The value that was passed to the setter.
     */
    public function __construct(string $message, string $value)
    {
        $message .= " Passed value: $value";
        parent::__construct($message, 400, null);
    }
}