<?php

/**
 * Class ApiRequest
 */
class ApiRequest
{
    private $baseUrl;
    private $curlCertificate;

    public function __construct()
    {
        $this->baseUrl = parse_ini_file('./config.ini', true)['API']['baseUrl'];
        $this->curlCertificate = parse_ini_file('./config.ini', true)['API']['certificate'];
    }

    private function sendRequest(String $url){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_CAPATH => $this->curlCertificate,
            CURLOPT_CAINFO => $this->curlCertificate,
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            echo "cURL Error:" .$http_code." && message :". $err;
        } else {
            return json_decode($response, true);
        }
    }

    /**
     * @param String $name
     * @return mixed
     */
    public function getPokemon(String $name)
    {
        $url = $this->baseUrl.'pokemon/'.$name;
        return ($this->sendRequest($url));
    }

    public function getAttack(String $url)
    {
        return $this->sendRequest($url);
    }

    public function getFrenchName(String $url)
    {
        return $this->sendRequest($url);
    }

    public function getEvolution($url)
    {
        return $this->sendRequest($url);
    }
}