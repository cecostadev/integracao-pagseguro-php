<?php

namespace BrPayments\Payments;

class PagseguroTest extends \PHPUnit\Framework\TestCase
{
    /*
    * Método que roda antes de todos os testes, gerando novos dados
    */
    public function setUp()
    {
        $access = [
            'email' => 'email@email.com',
            'token' => 'token123',
            'currency' => 'BRL',
            'reference' => '001'
        ];

        $this->pag_seguro = new PagSeguro($access);

        //dados do comprador = name,  areacode, phone, email
        $this->pag_seguro->customer('José Comprador', '51', '99999999', 'jose@comprador.com.br');

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
    }


    public function testListProducts()
    {
        $actual = $this->pag_seguro->toArray();
        $expected = [
            'email'=>'email@email',
            'token'=>'token123',
            'currency'=>'BRL',
            'reference'=>'001',
            'itemId1'=>1,
            'itemDescription1'=>'Vestido Rosa',
            'itemAmount1'=>'19.90',
            'itemQuantity1'=>1,
            'itemId2'=>2,
            'itemDescription2'=>'Vestido Azul',
            'itemAmount2'=>'39.90',
            'itemQuantity2'=>1,
            'senderName'=>'José Comprador',
            'senderAreaCode'=>51,
            'senderPhone'=>99999999,
            'senderEmail'=>'jose@comprador.com.br',
            'shippingType'=>1,
            'shippingAddressStreet'=>'Av. PagSeguro',
            'shippingAddressNumber'=>'50',
            'shippingAddressComplement'=>'',
            'shippingAddressDistrict'=>'Bela Vista',
            'shippingAddressPostalCode'=>99999999,
            'shippingAddressCity'=>'Alvorada',
            'shippingAddressState'=>'RS',
            'shippingAddressCountry'=>'BR',
        ];
        $this->assertEquals($expected, $actual);
    }

}