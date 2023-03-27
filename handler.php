<?php

require 'vendor/autoload.php';
require './service/ImgurService.php';

$configImgur = include('config/imgur.php');
$imgurService = new ImgurService();
redirect(parse_url($_SERVER['HTTP_REFERER'])['path'], $imgurService->parseHtmlImg($configImgur));

function redirect($url, $result, $statusCode = 303)
{
	header('Location: '.$url."?result=$result", true, $statusCode);
	die();
}
