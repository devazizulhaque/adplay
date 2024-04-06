<?php

class CampaignManager {
    private $campaigns;

    public function __construct($campaigns) {
        $this->campaigns = $campaigns;
    }

    public function selectCampaign(BidRequest $bidRequest) {
        $selectedCampaign = null;
        foreach ($this->campaigns as $campaign) {
            if ($campaign->getGeoTargeting() === $bidRequest->getGeo() &&
                $campaign->getDeviceCompatibility() === $bidRequest->getDevice() &&
                $campaign->getBidPrice() >= $bidRequest->getBidFloor()) {
                if ($selectedCampaign === null || $campaign->getBidPrice() > $selectedCampaign->getBidPrice()) {
                    $selectedCampaign = $campaign;
                }
            }
        }
        return $selectedCampaign;
    }
}
?>
