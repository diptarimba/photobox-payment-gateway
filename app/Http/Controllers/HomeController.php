<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Ramsey\Uuid\Uuid;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            if(isset($request->cost) && $request->cost !== null)
            {
                return $this->generateSnapToken($request->cost);
            }
        }
        $priceData = Price::get();
        $quote = Quote::inRandomOrder()->first();

        return view('home.index', compact('priceData', 'quote'));
    }

    public function generateSnapToken($cost = null)
    {
        $code = Uuid::uuid4() . '-' . substr(time(), -5);

        $params = array(
            'transaction_details' => array(
                'order_id' => $code,
                'gross_amount' => $cost,
            ),
            "enabled_payments" => ["gopay", "shopeepay"],
            'customer_details' => array(
                'first_name' => fake()->name(),
                'email' => fake()->safeEmail(),
            ),
        );
        // Generate new token
        $snapToken = Snap::getSnapToken($params);
        // Save token
        return response()->json(['token' => $snapToken]);
    }
}
