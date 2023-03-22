<?php

require 'vendor/autoload.php';

$configImgur = include('config/imgur.php');
header('Content-type: application/json');

echo json_encode([
	'result' => main($configImgur),
]);

function main($config): string
{
	$doc = new DOMDocument();
	$content = $_POST['content'] ?? null;
	if ($content) {
		$html = preg_split('/(<img[^>]+\>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);

		$token = $config['access_token'];

		foreach ($html as $index => $tag) {
			if (str_contains($tag, '<img')) {
				$doc->loadHTML($tag);
				$xpath = new DOMXPath($doc);
				$imgTag = $xpath->evaluate("string(//img/@src)");

				$html[$index] = '<img src="'.uploadImage($token, $imgTag).'">';
			}
		}
		return implode($html);
	}
	return '';
}

function uploadImage($accessToken, $urlImg)
{
	$urlImg = str_replace('\"', '', $urlImg);
	$curl = curl_init('https://api.imgur.com/3/image');

	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, [
		'image' => base64_encode(file_get_contents($urlImg)),
		'type' => 'base64'
	]);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		'Authorization: Bearer '.$accessToken
	));

	$response = curl_exec($curl);

	curl_close($curl);

	return json_decode($response)->data->link;
}
