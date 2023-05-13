<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $order_ids;
    public function __construct( $order_ids) {
        $this->order_ids=$order_ids;
     }
    public function view(): View
    { 
        $orders=Order::whereIn('id',$this->order_ids)
                ->orderBy('id','desc')
                ->get();
        return view('admin.booking.export_orders', [
            'orders' => $orders
        ]);
    }
}
