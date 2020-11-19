
@extends('layouts.master')

@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Order Details</h4>
            <div class="card-tools">
                Date: {{ $order_details->order_date }}
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
                <!-- Main content -->
    <section class="">
      
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>{{ company_info()->company_name }}</strong><br>
            {{ company_info()->company_address  }} <br>
            Phone: {{ company_info()->company_phone  }}<br>
            Email: {{ company_info()->company_email  }}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong>{{ $customer_info->customer_first_name.' '.$customer_info->customer_last_name }}</strong><br>
            {{ $customer_info->customer_address }}<br>
            Phone: {{ $customer_info->customer_phone }}<br>
            Email: {{ $customer_info->customer_email }}   
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Order ID:</b> {{ $order_details->order_code }}<br>
          <b>Payment Due:</b> {{ $order_details->order_date }}<br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Sl</th>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>   
                <?php
                 $sub_total = 0;
                 $grand_total = 0;
                ?>   

                @foreach($order_details->order_details as $value)

                <?php $sub_total += $value->order_product_price; ?>
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $value->order_product_name }}</td>
                  <td>{{ $value->order_product_quantity }}</td>
                  <td>{{ $value->order_product_price }}</td>
                  <td>{{ $value->order_product_price }}</td>
                </tr>
                @endforeach              
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-md-4">
          <p class="lead">Payment Methods:</p>
          <img src="../../dist/img/credit/visa.png" alt="Visa">
          <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
          <img src="../../dist/img/credit/american-express.png" alt="American Express">
          <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
          </p>
        </div>
        <div class="col-md-4"></div>
        <!-- /.col -->
        <div class="col-md-4">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td>{{ $sub_total }}</td>
              </tr>
              <tr>
                <th>Tax ({{ $order_details->order_tax_percent  }} %)</th>
                <td>{{ $order_details->order_tax_amount }}</td>
              </tr>
              <tr>
                <th>Shipping:</th>
                <td>$5.80</td>
              </tr>
              <tr>
                <th>Grand Total:</th>
                <td>{{ $sub_total + $order_details->order_tax_amount  }}</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button>
          <a href="{{ url('admin/order-pdf/'.$order_details->id) }}" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </a>
        </div>
      </div>
    </section>
    <!-- /.content -->
        </div>
    </div>
</div>


    @endsection