<?php

namespace Pine\SimplePay\Payloads;

use WC_Order;
use Pine\SimplePay\Support\Config;

abstract class General
{
    /**
     * The data.
     *
     * @var array
     */
    protected static $data = [];

    /**
     * Serialize the data.
     *
     * @param  \WC_Order  $order
     * @return void
     */
    protected static function serialize(WC_Order $order)
    {
        static::$data['ORDER_TIMEOUT'] = 300;
        static::$data['PAY_METHOD'] = 'CCVISAMC';
        static::$data['MERCHANT'] = Config::get('MERCHANT');
        static::$data['ORDER_REF'] = $order->get_order_key();
        static::$data['DISCOUNT'] = 0;
        static::$data['PRICES_CURRENCY'] = $order->get_currency();
        static::$data['ORDER_SHIPPING'] = $order->get_shipping_total() + $order->get_shipping_tax();
        static::$data['TIMEOUT_URL'] = $order->get_checkout_payment_url();
        static::$data['BACK_REF'] = $order->get_checkout_order_received_url();
        static::$data['ORDER_DATE'] = $order->get_date_created()->date('Y-m-d H:i:s');
        static::$data['LANGUAGE'] = substr(get_bloginfo('language'), 0, 2);
    }

    /**
     * Handle the data.
     *
     * @param  \WC_Order  $order
     * @return array
     */
    public static function handle(WC_Order $order)
    {
        static::serialize($order);

        return static::$data;
    }
}
