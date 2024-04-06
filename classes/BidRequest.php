<?php
class BidRequest {
    private $device;
    private $geo;
    private $adFormat;
    private $bidFloor;

    public function __construct() {
        $this->device = $this->getDevice();
        $this->adFormat = $this->getAdFormat();
        $this->geo = $this->getGeo();
        $this->bidFloor = $this->getBidFloor();
    }

    public function getDevice() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function getGeo() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $geo_data = file_get_contents("http://ip-api.com/json/$ip");
        $geo_data = json_decode($geo_data);
        $geo = array(
            "device" => $this->getDevice(),
            "geo" => array(
                "lat" => isset($geo_data->lat) ? $geo_data->lat : null,
                "lon" => isset($geo_data->lon) ? $geo_data->lon : null,
                "country" => isset($geo_data->country) ? $geo_data->country : null,
                "city" => isset($geo_data->city) ? $geo_data->city : null,
                "zip" => isset($geo_data->zip) ? $geo_data->zip : null
            )
        );
        return $geo;
    }

    public function getAdFormat() {
        $user_agent = $this->device;
        $formats = array(
            'iPhone' => array(
                array("w" => 776, "h" => 393),
                array("w" => 667, "h" => 375),
                array("w" => 640, "h" => 360),
            ),
            'Android' => array(
                array("w" => 568, "h" => 320),
                array("w" => 320, "h" => 480),
            ),
            'iPad' => array(
                array("w" => 1024, "h" => 768),
                array("w" => 768, "h" => 1024),
            ),
        );
        if (strpos($user_agent, 'iPhone') !== false || strpos($user_agent, 'iOS') !== false) {
            $device_type = 'iPhone';
        } elseif (strpos($user_agent, 'Android') !== false) {
            $device_type = 'Android';
        } elseif (strpos($user_agent, 'iPad') !== false) {
            $device_type = 'iPad';
        } elseif (strpos($user_agent, 'Windows Phone') !== false) {
            $device_type = 'Windows Phone';
        } elseif (strpos($user_agent, 'Macintosh') !== false) {
            $device_type = 'Macintosh';
        } elseif (strpos($user_agent, 'Windows') !== false) {
            $device_type = 'Windows';
        } elseif (strpos($user_agent, 'Linux') !== false) {
            $device_type = 'Linux';
        } else {
            $device_type = 'Unknown';
        }
        if (array_key_exists($device_type, $formats)) {
            return $formats[$device_type];
        } else {
            return "Unknown Format";
        }
    }
    public function getBidFloor() {
        return 0.01;
    }

    public function sendBidRequest() {
        $url = "https://realtimebidding.googleapis.com/v1/{data/*}";
    
        $data = array(
            'device' => array(
                'ua' => $this->device,
                'geo' => $this->geo
            ),
            'format' => $this->adFormat,
            'bidfloor' => $this->bidFloor
        );
    
        $data_string = json_encode($data);
    
        $ch = curl_init($url);
    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
    
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
?>
