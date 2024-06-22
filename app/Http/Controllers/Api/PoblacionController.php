<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PoblacionModel; // Asegúrate de usar el modelo correcto
use League\Csv\Reader;
use Illuminate\Support\Facades\Validator;

class PoblacionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'csv_file' => 'required|file|mimes:csv,txt',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $csvFile = $request->file('csv_file');
            $csv = Reader::createFromPath($csvFile->getRealPath(), 'r');
            $csv->setHeaderOffset(0);

            foreach ($csv as $record) {
                PoblacionModel::create([
                    'CodProvincia' => $record['CodProvincia'],
                    'Provincia' => $record['Provincia'],
                    'CodMunicipio' => $record['CodMunicipio'],
                    'Municipio' => $record['Municipio'],
                    'Poblacion' => $record['Poblacion'],
                ]);
            }

            return response()->json(['message' => 'Datos cargados exitosamente']);
        } catch (\Exception $e) {
            // Considera agregar logging aquí para más detalles
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getChartData()
{
    try {
        // Recuperar todos los registros para el gráfico
        $allData = PoblacionModel::all();

        // Recuperar los 10 registros más relevantes basados en la población
        $topTenData = PoblacionModel::orderBy('Poblacion', 'desc')
                                    ->take(10)
                                    ->get();
        return response()->json([
            'allData' => $allData,
            'topTenData' => $topTenData,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}