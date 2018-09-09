<?php

require '../../vendor/autoload.php';

$access = [
    'email' => '',
    'token' => 'A',
    'currency' => 'BRL',
    'reference' => '001'
];

$pag_seguro = new BrPayments\Payments\PagSeguro($access);

//dados do comprador = name,  areacode, phone, email
$pag_seguro->customer('José Comprador', '51', '99999999', '');

//dados de entrega =  type, street, number, complement, district, postal, city, state, country
$pag_seguro->shipping(
    1,
    'Av. Pagseguro',
    '50',
    '',
    'Bela Vista',
    9999999999,
    'Alvorada',
    'RS',
    'BR'
);

//dados do produto = id, description, amount, quantity, weight(optional)
$pag_seguro->addProduct(1, 'Vestido Rosa', 19.90, 1, 1);
$pag_seguro->addProduct(2, 'Vestido Azul', 39.90, 1, 1);

$pag_seguro_request = new BrPayments\Requests\PagSeguro;
$response =  (new BrPayments\MakeRequest())->post($pag_seguro, true);
$xml = new \SimpleXMLElement((string)$response);
$pag_seguro_request->getUrlFinal($xml->code, true);


?>

<!DOCTYPE html>
<html lang="en">
<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <button onclick="PagSeguroLightbox('<?php echo $xml->code ?>')">Pagar com Pagseguro</button>
</body>
</html>