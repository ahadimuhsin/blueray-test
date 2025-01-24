<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OrderController extends Controller
{

    public function index(Request $request, OrderService $orderService)
    {
        try {
            $response = $orderService->index($request);

            return ResponseFormatter::success($response, "List Order", HttpResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return ResponseFormatter::error($e->getMessage(), $e->getCode());
        }
    }

    public function statistic(Request $request, OrderService $orderService)
    {
        try {
            $response = $orderService->statistic($request);

            return ResponseFormatter::success($response, "Statistic Order", HttpResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return ResponseFormatter::error($e->getMessage(), $e->getCode());
        }
    }
    public function tracking(string $trackingId, OrderService $orderService)
    {
        try {
            $response = $orderService->tracking($trackingId);

            return ResponseFormatter::success($response, "Tracking Success", HttpResponse::HTTP_OK);

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return ResponseFormatter::error($e->getMessage(), $e->getCode());
        }
    }

    public function store(CreateOrderRequest $request, OrderService $orderService)
    {
        $data = $request->validated();

        try {
            $response = $orderService->store($data);

            return ResponseFormatter::success($response, "Order created successfully", HttpResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return ResponseFormatter::error($e->getMessage(), $e->getCode());
        }
    }
}
