<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function saveOrder(Request $request){
        // dd($request);
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'country' => 'required|max:255',
            'address' => 'required|max:512',
            'state' => 'required|max:255',
            'postcode' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|max:255'
        ]);

        $order = Order::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'country' => $request->country,
            'address' => $request->address,
            'state' => $request->state,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => Order::STATUS_PENDING,
            'total' => 0,
            'note' => '',
            'user_id' => Auth::user()->id
        ]);

        // dd($order);

        $cart = session()->get('cart') ?? [];

        $total = 0;
        foreach($cart as $item){
            $totalRow = $item['qty'] * $item['price'];

            OrderProduct::create([
                'name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'total' => $totalRow,
                'order_id' => $order->id
            ]);

            $total += $totalRow;
        }
        //Update total of Order
        $order->total = $total;
        $order->save();

        //session()->flush();
        session()->forget('cart');

        //Send mail to customer

        //Send mail to Admin
        $data = [
            'content' => ' You have 1 order new !!!',
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'order_total' => $order->total,
            'order_products' => $order->products->toArray(),
        ];
        Mail::to("hoangbaobk01@gmail.com")->send(new OrderMail($data));

        return redirect()->route('home')->with('checkout','success');
    }
}
