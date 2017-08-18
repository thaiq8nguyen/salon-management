<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 8/16/17
 * Time: 9:32 PM
 */
namespace Salon\GiftCertificates;

use App\GiftCertificate;

use Carbon\Carbon;

use Salon\Square\Square;

class GiftAPI{
    protected $gift;

    public function __construct(GiftCertificate $giftCertificate)
    {
        $this->gift = $giftCertificate;
    }

    public function getDailyGiftsSold(){

        $gifts = Square::getDailyGiftsSold();

        foreach($gifts as $gift){
            $this->gift->updateOrCreate(['squareId' => $gift['squareId']],$gift);
        }



    }
}


