<?php
header("Content-Type: text/html; charset=utf-8");
include("config/config.php");
include(DIRREQ."lib/vendor/autoload.php");
include(DIRREQ."helpers/variables.php");

$dispatch=new Classes\ClassDispatch();
include($dispatch->getInclusao());

use Models\ClassCrud;
$crud=new ClassCrud();
$crud->insertDB(
    "users",
    "?,?,?,?,?,?,?,?,?,",
    array(
        0,
        'Camila',
        'camilafranca8@gmail.com',
        '123',
        '08/06/1989',
        '111.222.333-22',
        '',
        'users',
        'ativo'

    )
);
