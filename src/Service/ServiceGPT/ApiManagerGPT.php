<?php

// src/Service/ApiManagerGPT.php

namespace App\Service\ServiceGPT;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiManagerGPT
{
    private HttpClientInterface $httpClient;
    private string $openAiApiKey;

    // Remover o construtor e usar métodos setter
    public function setHttpClient(HttpClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    public function setOpenAiApiKey(string $openAiApiKey): void
    {
        $this->openAiApiKey = $openAiApiKey;
    }


    public function getResponseFromGPT($text, $configs = [])
    {
        
        if (!$text) {
            return 'É Preciso adicionar um text' ;
        }

        $data = array_merge([
            'model' => "gpt-3.5-turbo",
            'messages' => [
                ["role" => "system", "content" => "Você é um assistente de IA."],
                ["role" => "user", "content" => $text],
            ],
        ], $configs);

        try {
            $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->openAiApiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            $content = $response->toArray();

            return $content['choices'][0]['message']['content'] ?? 'Desculpe, não consegui processar sua solicitação.';

        } catch (\Exception $e) {

            return 'Ocorreu um erro ao processar sua solicitação: ' . $e->getMessage();
        }
    }
}
