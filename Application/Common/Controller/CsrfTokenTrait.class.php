<?php
namespace Common\Controller;

use Common\Utils\CsrfToken;

trait CsrfTokenTrait
{
    public function validateCsrfToken(string $csrfToken) : bool
    {
        return CsrfToken::validate($csrfToken);
    }
}
