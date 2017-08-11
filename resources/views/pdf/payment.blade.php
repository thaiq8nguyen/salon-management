@extends('layouts.pdf-main')
@section('title',$technician->full_name .'\'s Wage Report')
@section('content')
     <div class = "container">
         <div class = "row">
             <div class = "heading-wrapper">
                 <table class = "heading-table">
                     <tr>
                         <td>{{$technician->full_name}}</td>
                         <td>Pay Period: {{$payPeriod}}</td>
                         <td>Pay Date: {{ $payDate }}</td>
                     </tr>
                 </table>
             </div>
         </div>
        <hr>
         <div class = "row">
             <div class = "sale-table-container">
                 <h4>Sales</h4>
                 <table class = "sale-table">
                     <tr>
                         <th>Date</th>
                         <th>Sales</th>
                         <th>Tips</th>
                     </tr>
                     @foreach($technician->dailySales as $dailySale)
                         <tr>
                             <td>{{ $dailySale->sale_date_mdyd }}</td>
                             <td>{{ $dailySale->sales_amount }}</td>
                             <td>{{ $dailySale->additional_sales_amount  }}</td>
                         </tr>
                     @endforeach
                 </table>
             </div>
             <div class = "earning-table-container">
                 <h4>Earnings</h4>
                 <table class = "earning-table">
                     <tr>
                         <th>Earning</th>
                         <th>Tips Deduction</th>
                         <th>Total Earning</th>
                     </tr>
                     <tr>
                         <td>$ {{ $technician->totalSalesAndTips[0]->earnedTotal }}</td>
                         <td>$ {{ $technician->totalSalesAndTips[0]->earnedTip }}</td>
                         <td>$ {{ $technician->totalSalesAndTips[0]->total }}</td>
                     </tr>
                 </table>
             </div>
         </div>
         <div class = "row">
             <div class = "subtotal-table-container">
                 <table class = "subtotal-table">
                     <th>Sub Total</th>
                     <td>$ {{ $technician->totalSalesAndTips[0]->subTotal }}</td>
                     <td>$ {{ $technician->totalSalesAndTips[0]->subTotalTip }}</td>
                 </table>
             </div>
             <div class = "payments-table-container">
                 <h4>Payments</h4>
                 <table class = "payments-table">
                     <tr>
                         <th>Amount</th>
                         <th>Method</th>
                         <th>Reference</th>
                     </tr>
                     @foreach($technician->payments as $payment)
                         <tr>
                             <td>$ {{ $payment->amount }}</td>
                             <td>{{ $payment->method }}</td>
                             <td>{{ $payment->reference }}</td>
                         </tr>
                     @endforeach
                 </table>
             </div>
         </div>
         <div class = "row">
             <div class = "balance-container">
                 <h4>Balance: $ {{ $book->balance }}</h4>
             </div>
         </div>
     </div>
@endsection
