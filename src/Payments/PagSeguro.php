<?php

namespace BrPayments\Payments;

class PagSeguro
{   
    protected $config;
    protected $sender;
    protected $shipping;
    protected $products;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __toString()
    {
        return http_build_query($this->toArray());
    }
    
    public function customer($name, $areacode, $phone, $email)
    {
        $this->sender = [
            'senderName' => $name,
            'senderAreaCode' => $areacode,
            'senderPhone' => $phone,
            'senderEmail' => $email
        ];


    }

    public function addProduct($id, $description, $amount, $quantity, $weight = null)
    {
        $this->products[] = [
            'id' => $id,
            'description' => $description,
            'amount' => $amount,
            'quantity' => $quantity,
            'weight' => $weight
        ];
    }

    public function shipping($type, $street, $number, $complement, $district, $postal, $city, $state, $country)
    {
        $this->shipping = [
            'shippingType' => $type,
            'shippingAddressStreet' => $street,
            'shippingAddressNumber' => $number,
            'shippingAddressComplement' => $complement,
            'shippingAdressDistrict' => $district,
            'shippingAdressPostalCode' => $postal,
            'shippingAdressCity' => $city,
            'shippingAdressState' => $state,
            'shippingAdressCountry' => $country,
        ];
    }

    public function toArray() :array
    {
        $items = [];

        foreach($this->products as $k=>$product){
            $counter = $k+1;
            $items['itemId'.$counter] = $product['id'];
            $items['itemDescription'.$counter] = $product['description'];
            $items['itemAmount'.$counter] = number_format($product['amount'],2 , '.', '');
            $items['itemQuantity'.$counter] = $product['quantity'];
            $items['itemWeight'.$counter] = $product['weight'];
        }

        return array_merge($this->config, $items, $this->sender, $this->shipping);
    }
}