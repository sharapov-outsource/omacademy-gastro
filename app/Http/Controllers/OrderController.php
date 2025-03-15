<?php
/**
 * @copyright Alexander S. <alexander@sharapov.biz>
 * @link http://www.sharapov.biz/
 * @link https://golance.com/freelancer/alexander.sharapov
 * @link https://www.upwork.com/freelancers/sharapov
 * Date: 15.03.2025
 * Time: 15:30
 */


namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = Order::create(['user_id' => auth()->id()]);

        foreach ($request->dishes as $dishUuid => $selected) {
            if ($selected) {
                OrderItem::create([
                    'order_id'   => $order->uuid,
                    'menu_id'    => $dishUuid,
                    'quantity'   => $request->quantities[$dishUuid] ?? 1,
                ]);
            }
        }

        return back()->with('success', 'Заказ успешно добавлен!');
    }
}
