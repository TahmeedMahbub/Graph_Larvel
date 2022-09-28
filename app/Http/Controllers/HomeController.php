<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

use App\Product;
use App\Invoice;
use App\SoldItem;


class HomeController extends Controller
{


    public function googleLineChart()
    {
        // $visitor = DB::table('visitor')
        //             ->select(
        //                 DB::raw("day(created_at) as day"),
        //                 DB::raw("SUM(click) as total_click"),
        //                 DB::raw("SUM(viewer) as total_viewer")) 
        //             ->orderBy("created_at")
        //             ->groupBy(DB::raw("day(created_at)"))
        //             ->get();


        $everyday = Invoice::join('sold_items', 'invoices.id', '=', 'sold_items.invoice_id')
            ->join('products', 'products.id', '=', 'sold_items.product_id')
            ->select(

                DB::raw('DAY(invoices.date) as today'),
                DB::raw('SUM(products.selling_price * sold_items.quantity) as revenue'),
                DB::raw('(SUM(products.selling_price * sold_items.quantity) - SUM(products.purchase_price * sold_items.quantity)) as profit'),
                DB::raw('SUM(sold_items.quantity) as total_product'),
            
            )
            ->orderBy('invoices.date')
            ->groupBy('invoices.date')
            ->get();

        // dd($everyday);


        $chart_val[] = ['Day','Revenue','Profit'];
        foreach ($everyday as $key => $value) {
            $chart_val[++$key] = [$value->today, (int)$value->revenue, (int)$value->profit];
        }


        return view('google-line-chart')
                ->with('chart_val',json_encode($chart_val));
    }


}