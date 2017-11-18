<?php
include_once 'generateCsrfToken.php';
/**
 * 生成 csrf token 令牌
 */
function smarty_function_marmot_csrf()
{
    return generateCsrfToken();
}
