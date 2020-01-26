<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DeviseService
{
    const API_ENDPOINT = "https://api.exchangeratesapi.io/latest";
    const DEVISES = ["HRK", "JPY", "USD", "PHP"];
    const SESSION_DEVISE = 'devise';

    public $rates = [
        "EUR" => 1,
    ];
    public $devise = "EUR";
    public $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->getDevises();
        $this->devise = $session->get(self::SESSION_DEVISE, "EUR");
    }

    private function getDevises()
    {
        $client = HttpClient::create();

        $res = $client->request("GET", self::API_ENDPOINT)->toArray();

        foreach ($res["rates"] as $currency => $rate) {
            foreach (self::DEVISES as $DEVISE) {
                if ($DEVISE == $currency) {
                    $this->rates[$currency] = $rate;
                }
            }
        }
    }

    public function getDevise($baseAmount) {
        return $this->toDevise($baseAmount, $this->devise);
    }

    public function getStringDevise() {
        return $this->devise;
    }

    public function setUserDevise($devise) {

        $this->devise = $devise;
        $this->session->set(self::SESSION_DEVISE, $this->devise);
    }

    private function toDevise($baseAmount, $currency) {
        return $baseAmount * ( $this->rates[$currency] );
    }
}