<?php

namespace App\Livewire\Admin;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderDetail;
use Livewire\Component;
use Livewire\WithPagination;

class OrderDetails extends Component
{
    use WithPagination;
    public $order_id;
    protected $paginationTheme = 'bootstrap';
    public $search;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function changeStatus($order_detail_id)
    {
        $order_detail = OrderDetail::query()->find($order_detail_id);
        if($order_detail->status === OrderStatus::Received->value){
            $order_detail->update([
                'status' => OrderStatus::Rejected->value
            ]);
        }elseif ($order_detail->status === OrderStatus::Processing->value){
            $order_detail->update([
                'status' => OrderStatus::Received->value
            ]);
        }else{
            $order_detail->update([
                'status' => OrderStatus::Processing->value
            ]);
        }
    }

    public function render()
    {
        $order_details = OrderDetail::query()->where('order_id',$this->order_id)
            ->paginate(10);
        $total_price = Order::query()->find($this->order_id)->total_price;
        return view('livewire.admin.order-details',compact('total_price','order_details'));
    }
}
