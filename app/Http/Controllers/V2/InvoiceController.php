<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function store(Order $order, OrderService $service)
    {

       try{
           $invoice = $service->createInvoice($order);
       }catch(\Exception $th)
       {
           return response()->json(['message' => $th->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
       }

       return $invoice->invoice_number;
        
    }
}
