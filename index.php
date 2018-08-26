<?php

$ayar = [
	
	'bot_anahtari' => 'Anahtariniz',
	'sadece_guvenli' => TRUE,
	'guvenlik' => [ 
		'Sohbet Numarasi' 
		],
	];
	

$veri = file_get_contents("php://input");
$guncelle = json_decode($veri, true);
$sohbetnumarasi = $guncelle["message"]["chat"]["id"];
$mesaj = $guncelle["message"]["text"];
// Aktif Komutlar
$komutlar = [
	// Genel Komutlar
	'yardim',
	// Sunucu Komutları
	'sunucu',
	//Örnek /sunucu ddosat ip port
	'ddosat',
	

];
$argumanlar = [
	// Sunucu
	'sunucu'=>[
		'ddosat',
	],
	'yardim'=>[
		'sunucu',
	],
];
// Komutlar
$komutlarim = [
	'ddosat'=>'sunucu',
];
$lan = explode(' ', trim($mesaj));
$komutlar = ltrim(array_shift($lan), '/');
$metod = '';
if (isset($lan[0]) && in_array($lan[0], $argumanlar[$komutlar])) {
	$metod = array_shift($lan);
}
else { 
	if (in_array($komutlar, array_keys($komutlarim))) {
		$metod = $komutlar;
		$komutlar = $komutlarim[$komutlar];
	}
}
switch ($komutlar) {
	case 'sunucu':
		$sinif = 'sunucu';
		break;
	case 'yardim':
		$sinif = 'destek';
		break;
	default:
		$sinif = 'Bot';
}
$olustur = new $sinif($conf, $sohbetnumarasi);
if (!$olustur->isTrusted()) {
	$olustur->unauthorized();
	die();
}
if (!in_array($komutlar, $komutlarr)) {
	$olustur->unknown();
}
else {
	if (isset($arguman[$komutlar]) && in_array($metod, $arguman[$komutlar])) {
		$olustur->{$metod}($lan);
		die();
	} else if (in_array($komutlar, $komutlarr)) {
		$olustur->{$komutlar}($lan);
	} else {
		$olustur->unknown();
	}
}
?>
