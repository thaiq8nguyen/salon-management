<?php
namespace Salon\Square;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Config;

Class SquareAPI{

    protected $client;
    protected $requestHeaders;
    protected $dates;


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
                $paginationHeader = $response->getHeaders()['Link'][0];
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

    /**
     * @param $saleDate
     * @return array
     * This is run on demand depending on the user's sale date to find and import all g/c sold on that date
     */
    public function getGiftCardsSold($saleDate){

        $date = Carbon::createFromFormat('Y-m-d',$saleDate)->startOfDay();
        $this->setDatesQuery($date);

        $payments = $this->getRawPayments($this->dates);

        $gifts = [];

        foreach($payments as $payment){
            foreach($payment->itemizations as $item){
                if($item->name == 'Gift Certificate'){
                    $date = Carbon::parse($payment->created_at,'UTC')->timezone('America/Los_Angeles');

                    $gift = ['squareId' => $payment->tender[0]->id,
                        'amount' => $this->formatMoney($item->total_money->amount),
                        'sold_at' => $date->toDateTimeString(),
                        'expired_at' => $date->addYears(1)->toDateTimeString()];
                    array_push($gifts, $gift);
                }
            }
        }

        return $gifts;

    }
    /**
     * @return array
     * This is run daily in order to get and import all gift certificates sold on that date
     */
    public function getDailyGiftsSold(){

        $date = Carbon::now()->startOfDay();
        $this->setDatesQuery($date);

        $payments = $this->getRawPayments($this->dates);

        $gifts = [];

        foreach($payments as $payment){
            foreach($payment->itemizations as $item){
                if($item->name == 'Gift Certificate'){
                    $date = Carbon::parse($payment->created_at,'UTC')->timezone('America/Los_Angeles');

                    $gift = ['squareId' => $payment->tender[0]->id,
                        'amount' => $this->formatMoney($item->total_money->amount),
                        'sold_at' => $date->toDateTimeString(),
                        'expired_at' => $date->addYears(1)->toDateTimeString()];
                    array_push($gifts, $gift);
                }
            }
        }

        return $gifts;

    }
    public function getDailySaleMetrics(){

        $date = Carbon::now()->startOfDay();

        $this->setDatesQuery($date);


        $payments = $this->getRawPayments($this->dates);
        $items = [];
        $totalCollected = 0;
        $tipOnCard = 0;
        $cashCollected = 0;
        $cardCollected = 0;
        $processingFee = 0;
        $refunded = 0;

        foreach($payments as $payment){

            $totalCollected += $payment->total_collected_money->amount;
            $tipOnCard += $payment->tip_money->amount;
            $processingFee += $payment->processing_fee_money->amount;
            $refunded += $payment->refunded_money->amount;

            foreach($payment->tender as $tender){
                if($tender->type == 'CASH'){
                    $cashCollected += $tender->total_money->amount;
                }
                else if($tender->type == 'CREDIT_CARD'){
                    $cardCollected += $tender->total_money->amount;
                }
            }
            foreach($payment->itemizations as $item){
                array_push($items,$item);
            }

        }
        $saleItem = $this->getDailySaleItems($items);

        $grossSales = $totalCollected - $tipOnCard;
        $data = ['metrics' => ['gross_sales' => $this->formatMoney($grossSales),
            'tips' => $this->formatMoney($tipOnCard), 'fees' => $this->formatMoney(abs($processingFee)),
            'cash_collected' => $this->formatMoney($cashCollected),
            'cards_collected' => $this->formatMoney($cardCollected), 'refunded' => $this->formatMoney($refunded)],'items' =>$saleItem];

        return $data;

    }

    public function getDailySaleItems($soldItems){

        $menus = ['Convenience Fee','Gift Certificate'];

        $itemSoldList = [];

        foreach($menus as $menu){
            $itemSold = 0;
            $grossSales = 0;
            foreach($soldItems as $soldItem){
                if($soldItem->name == $menu){
                    $itemSold += 1;
                    $grossSales += $soldItem->gross_sales_money->amount;
                }
            }
            $itemSoldList[] = ['item' => $menu,'gross_sales' => $this->formatMoney($grossSales),'items_sold' => $itemSold];

        }

        return $itemSoldList;

    }
    private function setDatesQuery(Carbon $beginDate){

        $newDate = clone $beginDate;

        $endDate=  $newDate->addDay();

        $this->dates = http_build_query(['begin_time' => $beginDate->toIso8601String(),
            'end_time' => $endDate->toIso8601String()]);

    }
    private function formatMoney($money){
        return money_format('%+.2n',$money/100);
    }
}