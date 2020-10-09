<?php

namespace Cmever\ES_Log;
class TapjoyFetch
{
    private $settings;
    private $token;

    function __construct()
    {
        if (file_exists(__DIR__ . "/settings.json")) {
            $this->settings = json_decode(file_get_contents(__DIR__ . "/settings.json"), true);
        }
        if (empty($this->settings)) {
            echo "Missing settings\n";
        }
    }

    public function resetSettings($settings)
    {
        $this->settings = $settings;
    }

    private function getAccess()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "api.tapjoy.com/v1/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic " . $this->settings['Publisher_Reporting_API_Key']
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }

    public function resetToken()
    {
        $this->token = $this->getAccess()['access_token'];
    }

    public function fetchData($date = null, $page_size = 1000, $page = 1)
    {
        if (empty($date)) {
            $date = date("Y-m-d");
        }
        if (empty($this->token)) {
            $this->resetToken();
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "api.tapjoy.com/v2/publisher/reports?date=$date&page_size=$page_size&page=$page",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $this->token"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }
}