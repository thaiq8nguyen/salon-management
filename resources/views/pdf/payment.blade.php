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
                     @foreach($sales->dailySales as $dailySale)
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
                         <td>$ {{ $wage->totalSalesAndTips[0]->earnedTotal }}</td>
                         <td>$ {{ $wage->totalSalesAndTips[0]->earnedTip }}</td>
                         <td>$ {{ $wage->totalSalesAndTips[0]->total }}</td>
                     </tr>
                 </table>
             </div>
         </div>
         <div class = "row">
             <div class = "subtotal-table-container">
                 <table class = "subtotal-table">
                     <th>Sub Total</th>
                     <td>$ {{ $wage->totalSalesAndTips[0]->subTotal }}</td>
                     <td>$ {{ $wage->totalSalesAndTips[0]->subTotalTip }}</td>
                 </table>
             </div>
             <div class = "payments-table-container">
                 @php
                    $totalPayment = 0;
                 @endphp
                 <h4>Payments</h4>
                 <table class = "payments-table">
                     <tr>
                         <th>Amount</th>
                         <th>Method</th>
                         <th>Reference</th>
                     </tr>
                     @foreach($payments->payments as $payment)
                        @php
                            $totalPayment += $payment->amount;
                        @endphp
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
                 <h4>Balances</h4>
                 <p>Previous Balance: $ {{ number_format($previousBalance['period_balance'],2,'.',',') }}</p>
                 <p>( + )  Total Earning: $ {{ number_format($wage->totalSalesAndTips[0]->total,2,'.',',')}}</p>
                 <p>( - )  Total Payment: $ {{ number_format($totalPayment,2,'.',',') }}</p>
                 <p>Pay Period Balance: $ {{ number_format($periodBalance['period_balance'],2,'.',',') }}</p>
                 <p>Balance: $ {{ number_format($totalBalance['total_balance'],2,'.',',') }}</p>
             </div>
         </div>
         <div class = "row">
             <div class = "message-container">
                 <h4>Important Message</h4>
                 <p>Sugar Nails now offers technician's sale, wage, pay reports at
                     <span style="text-decoration: underline">salon.resonancecorp.com</span></p>
                 <p>Instructions</p>
                 <ol>
                     <li>Go to <span style = "text-decoration: underline">salon.resonancecorp.com</span> on your mobile phone.</li>
                     <li>Click on Register</li>
                     <li>Use Invitation Code <span style = "font-weight: bold">{{ $technician->id }}</span>.</li>
                     <li>Complete the form and click register.</li>
                     <li>Now you can access your account using your user name and password.</li>
                 </ol>
             </div>
         </div>
     </div>
@endsection
