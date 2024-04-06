<?php
require_once 'BidRequest.php';

class Campaign {
    public function getBidResponse() {
        $bidRequest = new BidRequest();
        $response = $bidRequest->sendBidRequest();
        return $response;
    }

    public function sendBidRequest() {
        
    }
}
?>
