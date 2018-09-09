<?php

namespace BrPayments;

class MakeRequestTeste extends \PHPUnit\Framework\TestCase 
{

    public function testPagseguroRequest()
    {
        $access = [
            'email' => '',
            'token' => '',
            'currency' => 'BRL',
            'reference' => '001'
        ];

        $this->pag_seguro = new Payments\PagSeguro($access);

        //dados do comprador = name,  areacode, phone, email
        $this->pag_seguro->customer('José Comprador', '51', '99999999', '');

        //dados de entrega =  type, street, number, complement, district, postal, city, state, country
        $this->pag_seguro->shipping(
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
        $this->pag_seguro->addProduct(1, 'Vestido Rosa', 19.90, 1, 1);
        $this->pag_seguro->addProduct(2, 'Vestido Azul', 39.90, 1, 1);

        $pag_seguro_request = new Requests\PagSeguro;
        $response =  (new MakeRequest())->post($this->pag_seguro, true);
        $xml = new \SimpleXMLElement((string)$response);
        $pag_seguro_request->getUrlFinal($xml->code, true);
    }
}