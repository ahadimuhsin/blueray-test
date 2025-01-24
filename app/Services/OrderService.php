<?php

namespace App\Services;

use Exception;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class OrderService
{
    public function index($request)
    {
        try {
            $orders = Order::select(["order_id", "tracking_id", "name as item_name", "description", "qty", "weight", "price",
            "sender_name", "sender_address", "sender_phone",
            "recipient_name", "recipient_address", "recipient_phone"])
            ->when($request->user()->role == User::ROLE_USER, function($q) use($request){
                $q->where("creator_id", $request->user()->id);
            })
            ->get();

            return $orders;

        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
    public function statistic($request)
    {
        try {
            $totalOrders = Order::count();

            return [
                "total" => $totalOrders
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw new Exception($e->getMessage(), 500);
        }
    }
    public function store($request)
    {
        $creatorId= auth()->id();

        $request["creator_id"] = $creatorId;

        DB::beginTransaction();
        try {
            $saveOrder= Order::create($request);

            $payload = [
                "origin_contact_name" => $request["sender_name"],
                "origin_address" => $request["sender_address"],
                "origin_contact_phone" => $request["sender_phone"],
                "origin_postal_code" => $request["sender_postal_code"],

                "destination_contact_name" => $request["recipient_name"],
                "destination_address" => $request["recipient_address"],
                "destination_contact_phone" => $request["recipient_phone"],
                "destination_postal_code" => $request["recipient_postal_code"],

                // courier
                "courier_company" => "jne",
                "courier_type" => "reg",
                "delivery_type" =>"now",
                "courier_insurance" => 5000,

                "items" => [
                    [
                    "name" => $request["name"],
                    "description" => $request["description"],
                    "quantity" => $request["qty"],
                    "value" => $request["price"],
                    "weight" => $request["weight"], //in grams
                    ]
                ]
            ];

             // Integrate to Biteship API Create an Order
             $orderBiteShip = Http::withHeaders([
                "Authorization" => config("biteship.api_key"),
                'Content-Type' => 'application/json'
             ])->post(config("biteship.base_url")."/v1/orders", $payload);

             if ($orderBiteShip->failed()) {
                 throw new Exception("Failed to create order at Biteship API", 500);
             }

             $orderId = $orderBiteShip->json()["id"];
             $trackingId = $orderBiteShip->json()["courier"]["tracking_id"];

             $saveOrder->order_id = $orderId;
             $saveOrder->tracking_id = $trackingId;

             $saveOrder->save();
            DB::commit();
            return $saveOrder;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            throw new Exception($e->getMessage(), 500);
        }
    }
    public function tracking(string $trackingId)
    {
        try {
            // endpoint to tracking using biteship api
            $response = Http::withHeaders([
                "Authorization" => config("biteship.api_key"),
            ])->get(config("biteship.base_url")."/v1/trackings/".$trackingId);

            if($response->failed()) {
                throw new Exception("Failed to fetch tracking data from Biteship API", 500);
            }

            $data = [
                "tracking_id" => $response->json()["id"],
                "order_id" => $response->json()["order_id"],
                "waybill_id" => $response->json()["waybill_id"],
                "courier" => $response->json()["courier"]["company"],
                "origin" => $response->json()["origin"],
                "destination" => $response->json()["destination"],
                "history" => $response->json()["history"],
            ];

            return $data;
        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}
