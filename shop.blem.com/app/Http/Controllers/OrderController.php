<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //订单列表
    public function index(){
        $rows = DB::select("select o.id,o.sn,o.address,o.total,o.tel,o.`name`,o.`status`,o.created_at,a.goods_name,a.amount from orders as o join (select order_id,GROUP_CONCAT(goods_name) as goods_name,GROUP_CONCAT(amount) as amount from order_details GROUP BY order_id) as a on o.id = a.order_id");
        foreach($rows as $row){
            $row->goods_name = explode(',',$row->goods_name);
            $row->amount = explode(',',$row->amount);
        }
        return view('Order.index',compact('rows'));
    }

    //订单状态
    public function status(Request $request){
        $order = Order::find($request->id);
        if($order->status == $request->status ){
            return back()->with('warning','请勿重复操作');
        }
        if($order->status == -1 && $request->status == 2){
            return back()->with('warning','该订单已取消，发货失败');
        }
        if($order->status == 3 && $request->status == -1){
            return back()->with('warning','该订单已完成，取消失败');
        }
        if($order->status == 0 && $request->status == 2){
            return back()->with('warning','该订单暂未支付，发货失败');
        }
        $order->status = $request->status;
        $order->save();
        return back()->with('success','更新订单状态成功');
    }
}
