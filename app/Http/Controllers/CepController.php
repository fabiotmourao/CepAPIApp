<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class CepController extends Controller
{
    public function index()
    {
        return view('cep');
    }

    public function exportar($ceps)
    {

        $cepsArray = array_map('trim', explode(',', $ceps));

        $csvFileName = Uuid::uuid4().'.csv';

        $csvFilePath = storage_path('app/' . $csvFileName);

        $csvFile = fopen($csvFilePath, 'a+');

        fputcsv($csvFile,  ['CEP', 'Logradouro', 'Bairro', 'Cidade', 'Estado']);

        foreach ($cepsArray as $cep) {
            $response = json_decode($this->getUrlData($cep), true);
            $data = [
                $response['cep'],
                $response['logradouro'],
                $response['bairro'],
                $response['localidade'],
                $response['uf']
            ];

            fputcsv($csvFile, $data);
        }

        fclose($csvFile);

        return response()->download($csvFilePath)->deleteFileAfterSend(true);
    }

    public function consultar(Request $request)
    {
        $cepsInput = $request->input('ceps');
        $cepsArray = array_map('trim', explode(',', $cepsInput));

        if (empty($cepsArray)) {
            return redirect()->back()->with('error', '*Por favor, insira um cep para consulta.');
        }

        $results = [];
        $cepErrors = [];

        foreach ($cepsArray as $cep) {
            $response = $this->getUrlData($cep);
            if ($response === false) {
                $cepErrors[] = "Erro ao consultar o CEP {$cep}";
                continue;
            }

            $cepData = json_decode($response, true);
            if ($cepData === null && json_last_error() !== JSON_ERROR_NONE) {
                $cepErrors[] = "Erro na resposta da API para o CEP {$cep}";
                continue;
            }

            if (isset($cepData['erro'])) {
                $cepErrors[] = "CEP {$cep} inválido ou não encontrado";
                continue;
            }

            $results[] = $cepData;
        }


        return view('cep', ['results' => $results, 'cepErrors' => $cepErrors, 'cepsInput' => $cepsInput]);
    }

    private function getUrlData($cep)
    {
        $url = env('API_CEP_URL_BASE');

        return file_get_contents("{$url}/{$cep}/json/");
    }
}
