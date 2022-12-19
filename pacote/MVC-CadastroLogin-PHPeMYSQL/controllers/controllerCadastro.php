<?php
$validate=new Classes\ClassValidate();
$validate->validateFields($_POST);
$validate->validateFinalCad($arrVar);
var_dump($validate->getErro());
$validate->validateCaptcha($gRecaptchaResponse);
echo $validate->validateFinalCad($arrVar);
