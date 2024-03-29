<?php

namespace ApsCreativas\ConektaPay\Traits;

use Conekta\Handler;
use Conekta\Order;
use Conekta\ParameterValidationError;
use Exception;
use Illuminate\Support\Facades\Validator;
use ConektaPay;

trait Chargeable
{
    use ConektaPay;

    private $shipping_contact;
    private $items;
    private $conekta_order;

    public function createOrder()
    {
        $order = [
            'line_items' => $this->items,
            'currency' => config('conekta.currency'),
            'customer_info' => [
                'customer_id' => $this->client->conekta_customer_id
            ],
        ];

        if ($this->shipping_contact) {
            $order['shipping_contact'] = [
                'address' => $this->shipping_contact
            ];
        }

        try {
            $this->conekta_order = Order::create($order);
            $this->update([
                'conekta_order_status' => $this->conekta_order['payment_status'],
                'conekta_order_id' => $this->conekta_order['id'],
                'conekta_order' => $this->conekta_order
            ]);
            return $this;
        } catch (ParameterValidationError  $error) {
            throw new ParameterValidationError;
        } catch (Handler $error) {
            throw new Handler($error);
        }
    }

    public function oxxopay()
    {
        $this->conekta_order = Order::find($this->conekta_order_id);
        $this->conekta_charge = $this->conekta_order->createCharge([
            'payment_method' => [
                'type' => 'oxxo_cash'
            ]
        ]);
        return $this->conekta_charge;
    }

    public function charge($token = null, $type = 'default')
    {
        try {
            $this->conekta_order = Order::find($this->conekta_order_id);
            $this->conekta_charge = $this->conekta_order->createCharge([
                'payment_method' => [
                    'type' => $type,
                    'token_id' => $token
                ]
            ]);

            return $this->conekta_order;
        } catch (ParameterValidationError $error) {
            throw new Exception($error->getMessage());
        } catch (Handler $error) {
            throw new Exception($error->getMessage());
        }
    }

    public function setShippingContact($shipping_contact)
    {
        $validator = Validator::make($shipping_contact, [
            'street1' => 'required|string',
            'postal_code' => 'required|numeric',
            'country' => 'required'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->getMessageBag());
        }
        $this->shipping_contact = $shipping_contact;
        return $this;
    }

    public function setItems($items)
    {
        $validator = Validator::make($items, [
            '*.name' => 'required|string',
            '*.unit_price' => 'required|integer',
            '*.quantity' => 'required|integer'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->getMessageBag());
        }

        $this->items = $items;
        return $this;
    }

    public function order()
    {
        return Order::find($this->conekta_order_id);
    }

    public function isPaid()
    {
        return $this->conekta_order_status === 'paid';
    }
}
