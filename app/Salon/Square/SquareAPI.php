<?php
namespace Salon\Square;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Config;

Class SquareAPI{

    protected $client;
    protected $requestHeaders;

    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->requestHeaders = [ 'Authorization' => Config::get('square.Authorization'),
            'Accept' => 'application/json',
            'Content-type' => 'application/json'];

    }

    public function getSalonLocation()
    {

        $response = $this->client->get('me/locations',['headers' => $this->requestHeaders]);
        $result = $response->getBody();

        return \GuzzleHttp\json_decode($result);

    }

    public function getRawPayments($date)
    {
        $requestPath = Config::get('square.LocationID') . '/payments?' . $date;

        $payments = [];

        $moreResult = true;

        while ($moreResult) {
            $response = $this->client->get($requestPath, ['headers' => $this->requestHeaders]);

            $payments = array_merge($payments, \GuzzleHttp\json_decode($response->getBody()));
            if (array_key_exists('Link', $response->getHeaders())) {
                $paginationHeader = $response->getHeaders()['Link'];
                if (strpos($paginationHeader, "rel='next'") !== false) {
                    $requestPath = explode('>', explode('<', $paginationHeader)[1])[0];
                } else {
                    $moreResult = false;
                }
            } else {
                $moreResult = false;
            }
        }
        $seenPaymentID = [];
        $uniquePayments = [];

        foreach ($payments as $payment) {

            if (array_key_exists($payment->id, $seenPaymentID)) {
                continue;
            }
            $seenPaymentID[$payment->id] = true;
            array_push($uniquePayments, $payment);
        }

        return $payments;
    }

    public function getDailySaleMetrics(){

        $beginDate = Carbon::now()->startOfDay();
        $newDate = clone $beginDate;
        $endDate=  $newDate->addDay();

        $dates = http_build_query(['begin_time' => $beginDate->toIso8601String(),
            'end_time' => $endDate->toIso8601String()]);

        $payments = $this->getRawPayments($dates);
        $totalCollected = 0;
        $tipOnCard = 0;
        $cashCollected = 0;
        $cardCollected = 0;
        $processingFee = 0;

        foreach($payments as $payment){
            $totalCollected += $payment->total_collected_money->amount;
            $tipOnCard += $payment->tip_money->amount;
            $processingFee += $payment->processing_fee_money->amount;

            foreach($payment->tender as $tender){
                if($tender->type == 'CASH'){
                    $cashCollected += $tender->total_money->amount;
                }
                else if($tender->type == 'CREDIT_CARD'){
                    $cardCollected += $tender->total_money->amount;
                }
            }

        }

        $grossSales = $totalCollected - $tipOnCard;
        $data = ['gross_sales' => $this->formatMoney($grossSales),
            'tips' => $this->formatMoney($tipOnCard), 'fees' => $this->formatMoney(abs($processingFee)),
            'cash_collected' => $this->formatMoney($cashCollected),
            'cards_collected' => $this->formatMoney($cardCollected)];

        return $data;

    }

    private function formatMoney($money){
        return money_format('%+.2n',$money/100);
    }
}