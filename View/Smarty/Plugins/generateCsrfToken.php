<?php

function generateCsrfToken() : string
{
    static $csrfToken;

    if (empty($csrfToken)) {
        $csrfToken = \Common\Utils\CsrfToken::generateToken();
    }

    return $csrfToken;
}
