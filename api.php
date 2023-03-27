<?php

require 'vendor/autoload.php';
require './service/ImgurService.php';

$configImgur = include('config/imgur.php');
$imgurService = new ImgurService();
header('Content-type: application/json');

echo json_encode([
    'result' => $imgurService->parseHtmlImg($configImgur),
]);
