<?php

namespace App\Twig;

use App\Service\DeviseService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{

    public $deviseService;
    public function __construct(DeviseService $deviseService)
    {
        $this->deviseService = $deviseService;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('currency_convert', [$this, 'currencyConvert']),
        ];
    }

    public function currencyConvert($number)
    {
        return $this->deviseService->getDevise($number);
    }
}