<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Traits\ApiStatusTrait;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiStatusTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPizzas()
    {
        $pizzas = Product::with('attributes')->get();
        $response['pizzas'] = $pizzas;
        return $this->successApiResponse($response);
    }

    public function storeOrder(Request $request)
    {
        $orderData = new Order();
        $orderData->ip_address = $request->ip();
        $orderData->total_price = $request->totalPrice;
        $orderData->delivery_charge = $request->deliveryCharge;
        $orderData->delivery_address = $request->deliveryAddress;
        $orderData->customer_name = $request->customerName;
        $orderData->customer_phone = $request->customerPhone;
        $orderData->customer_address = $request->customerAddress;
        $orderData->save();

        if ($request->cartInfo) {
            foreach ($request->cartInfo as $cartItem) {
                $orderDetails = new OrderDetail();
                $orderDetails->order_id = $orderData->id;
                $orderDetails->name = $cartItem['name'];
                $orderDetails->qty = $cartItem['qty'];
                $orderDetails->unit_price = $cartItem['price'];
                $orderDetails->total_price = $cartItem['qty'] * (int)$cartItem['price'];
                $orderDetails->attribute = $cartItem['size'];
                $orderDetails->save();
            }
        }

        $response['message'] = "Order has been placed successfully.";
        return $this->successApiResponse($response);
    }

    public function orderHistory(Request $request)
    {
        $ip = $request->ip();
        $orders = Order::where('ip_address', "like", "%$ip%")->with('orderDetails')->get();
        $response['orders'] = $orders;
        return $this->successApiResponse($response);
    }
}