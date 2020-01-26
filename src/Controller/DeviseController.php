<?php


namespace App\Controller;

use App\Service\CurrencyService;
use App\Service\DeviseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DeviseController extends AbstractController
{
    public function change(DeviseService $deviseService, Request $request, $to) {
        $deviseService->setUserDevise($to);

        $request->getSession()->getFlashBag();

        $referer = $request->headers->get('referer');

        return $this->redirect($referer);
    }
}