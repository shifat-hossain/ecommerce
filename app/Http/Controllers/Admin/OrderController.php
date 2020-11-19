<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\OrderDetail;
use PDF;
class OrderController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['all_orders'] = Order::all();    
        $data['all_customer'] = Customer::all();    
        return view("admin.orders.all_orders", $data);
    }

    public function create() {
        $data['all_customer'] = Customer::all();    
        $data['all_product'] = Product::all();    
        return view("admin.orders.add_orders", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $order = new Order;
        $request->validate([
            'product_id' => 'required',
            'customer_id' => 'required'
        ]);

        $customer_info = Customer::find($request->customer_id);    
        $product_info = Product::find($request->product_id); 
        

        // echo "<pre>";print_r($customer_info);
        // echo "<pre>";print_r($product_info);
        // die();
        

        $order->order_code = 'Order-123';
        $order->customer_id = $customer_info->id;
        $order->customer_name = $customer_info->customer_first_name.' '.$customer_info->customer_last_name;
        $order->order_status = 'PENDING';
        $order->order_tax_percent = '0.00';
        $order->order_tax_amount  = '0.00';
        $order->order_discount_amount  = '0.00';
        $order->order_sub_total   = '0.00';
        $order->order_grand_total   = '0.00';
        $order->order_date    = '2020-12-12';
        $order->save();
        
        $order_details = new OrderDetail;
        $order_details->order_id = $order->id;
        $order_details->order_product_id = $product_info->id;
        $order_details->order_code = $order->order_code;
        $order_details->order_product_name = $product_info->name;
        $order_details->order_product_quantity = '1';
        $order_details->order_product_price  = $product_info->price;
        $order_details->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
        $data['order_details'] = Order::where('id', $id)->first();
        $data['customer_info'] = Customer::find($data['order_details']->customer_id); 
        //echo "<pre>";print_r($data['order_details']);die();
        return view("admin.orders.order_details",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        // $data['order_data'] = Order::find($id);
        // return view('admin.orders.edit_orders', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // $order_data = Order::find($id);
        // $request->validate([
        //     'order_name' => 'required|unique:orders,order_name,'.$id,
        //     'order_code' => 'required|unique:orders,order_code,'.$id
        // ]);
        // $order_data->order_name = $request->order_name;
        // $order_data->order_code = $request->order_code;
        // $order_data->save();        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // order::find($id)->delete();
        // return redirect('admin/orders');
    }


    public function generate_pdf($id) 
    {
        // echo "<pre>";print_r($id);die();
        // $data['order_details'] = Order::where('id', $id)->first();
        // $data['customer_info'] = Customer::find($data['order_details']->customer_id);
        
        // echo "<pre>";print_r($id);die();
        $data['foo'] = 'test';
        $pdf = PDF::loadView('admin.orders.order_pdf',$data);

        return $pdf->download('order1.pdf');

        //  return view('admin.orders.order_pdf');
    }

}
