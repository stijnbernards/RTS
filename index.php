<?php

require_once 'libs/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Array(array(
    'index' => 'Hello {{ name }}!',
));
$twig = new Twig_Environment($loader);

echo $twig->render('index', array('name' => 'Fabien'));

?>