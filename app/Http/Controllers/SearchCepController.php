<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchCepController extends Controller
{
    /**
     * Prepara e busca os CEPs informados
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $reqCeps = $request->ceps;

        $ceps = explode(',', $reqCeps);

        $response = [];

        foreach ($ceps as $cep):
            // Válida o CEP antes do envio
            if (! preg_match('/^\d{5}-\d{3}$/', $cep) and ! preg_match('/^\d{8}$/', $cep)) {
                $response[] = [
                    'erro' => 'CEP ' . $cep . ' é inválido'
                ];

                continue;
            }

            $response[] = $this->apiViaCeps($cep);
        endforeach;

        return response()->json($response);
    }

    /**
     * Busca o CEP informado na API Via Ceps
     *
     * @param string $cep CEP do request
     *
     * @return array Resposta da cURL
     */
    private function apiViaCeps(string $cep): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'viacep.com.br/ws/' . $cep . '/json/',
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }
}
