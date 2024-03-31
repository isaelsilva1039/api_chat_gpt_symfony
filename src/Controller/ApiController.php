<?php

namespace App\Controller;

use App\Service\ServiceGPT\ApiManagerGPT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
  
    private ApiManagerGPT $apiManagerGPT;

    public function __construct(ApiManagerGPT $apiManagerGPT)
    {
        $this->apiManagerGPT = $apiManagerGPT;
    }

    
    #[Route('/api/ask-gpt', name: 'ask_gpt')]
    public function askGpt(Request $request): Response
    {
        $userInput = $request->query->get('prompt');
        $gptResponse = $this->apiManagerGPT->getResponseFromGPT($userInput);

        return new Response($gptResponse);
    }
}
