<?php
/**
 * 生成 csrf token 令牌
 */
function smarty_function_marmot_csrf()
{
    static $csrfToken;

    if (empty($csrfToken)) {
        $csrfToken = \Common\Utils\CsrfToken::generateToken();
    }

    return $csrfToken;
}
