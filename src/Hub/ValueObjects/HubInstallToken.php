<?php

namespace Mundipagg\Core\Hub\ValueObjects;

use Mundipagg\Core\Kernel\ValueObjects\AbstractValidString;

final class HubInstallToken extends AbstractValidString
{
    protected function validateValue($value)
    {
        return preg_match('/\w{64}$/', $value) === 1;
    }
}