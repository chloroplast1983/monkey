<head>
<meta content="{marmot_csrf}" name="X-CSRF-TOKEN">
</head>

<body>
<form action="/users/signIn" method="POST">

手机号:<input type="text" name="cellphone"/> <br />

密码:<input type="text" name="password"/> <br />

<img src="/utils/captcha" /> 验证码:<input type="text" name="phrase"/> <br />
{marmot_csrf_field}
<input type="submit" value="提交">
</form>
</body>
