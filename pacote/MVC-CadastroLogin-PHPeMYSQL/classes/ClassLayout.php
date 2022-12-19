<?php
namespace Classes;

class ClassLayout{
    public static function setHeadRestrito()
    {
        $session=new ClassSessions();
        $session->verifyInsideSession();
    }

    public static function setHead($title , $description , $author='Camila França')
    {
        $html="<!doctype html>\n";
        $html.="<html lang='pt-br'>\n";
        $html.="<head>\n";
        $html.="  <meta charset='UTF-8'>\n";
        $html.="  <meta name='viewport' content='width=device-width, initial-scale=1'>\n";
        $html.="  <meta name='author' content='$author'>\n";
        $html.="  <meta name='format-detection' content='telephone=no'>\n";
        $html.="  <meta name='description' content='$description'>\n";
        $html.="  <title>$title</title>\n";
        #FAVICON
        #STYLESHEET
        $html.=" <link rel='stylesheet' href='".DIRPAGE."libs/css/style.css'>\n";

        $html.="<body>\n";
        echo $html;
    }

    public static function setFooter()
    {
        $html="<script src='".DIRPAGE."lib/js/zepto.min.js'></script>\n";
        $html="<script src='".DIRPAGE."libs/js/vanilla-masker.min.js'></script>\n";
        $html.="<script src='".DIRPAGE."libs/js/javascript.min.js'></script>\n";
        $html.="<script src='https://www.google.com/recaptcha/api.js?render=".SITEKEY."'></script>";
        $html.="<script src='https://www.google.com/recaptcha/api.js?render=".SITEKEY."'></script>";
        $html="</body>\n";
        $html.="</html>";
        echo $html;
    }
}