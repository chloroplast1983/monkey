<?php
namespace Common\Controller;

use Common\Utils\CsrfToken;

trait CsrfTokenTrait
{
    private function validateCsrfToken() : bool
    {
        return $this->validateBodyToken() || $this->validateHeaderToken();
    }

    private function validateBodyToken() : bool
    {
        $csrfToken = $this->getRequest()->post('_token');
        return !empty($csrfToken) ? CsrfToken::validate($csrfToken) : false;
    }

    private function validateHeaderToken() : bool
    {
        $this->getRequest()->getHeader('X-CSRF-TOKEN');
        return !empty($csrfToken) ? CsrfToken::validate($csrfToken) : false;
    }
}
