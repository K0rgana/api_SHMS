<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Medicao;
use App\Sensor;
use App\API\ApiError;

class MedicaoController extends Controller
{
    private $medicao;

    public function __construct(Medicao $medicao)
	{
		$this->medicao = $medicao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(sizeof($this->medicao->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'nenhum medicao cadastrado']], 404);
        }
        else{
            $data = ['data' => $this->medicao::with('sensor')->get()];
            return response() -> json($data);
        }
    }

    /**
     * Store a newly created resource booleanrage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sensor_id' => 'required|numeric|min:1',
            'data_horario' => 'required|date_format:YYYY-MM-DD hh:mm:ss',
            'valor' => 'requiredIf($request->Sensor()->tipo->temperatura)|digits_between:-100,100',
            'valor' => 'requiredIf($request->Sensor()->tipo->luminosidade)|digits_between:0,100',
            'valor' => 'requiredIf($request->Sensor()->tipo->presenca)|numeric|boolean',
            'valor' => 'requiredIf($request->Sensor()->tipo->magnetico)|numeric|boolean',
        ]);

        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        try {
            $medicaodata = $request->all();
            $this->medicao->create($medicaodata);

			$return = ['data' => ['msg' => 'medicao criada com sucesso.']];
			return response()->json($return, 201);
		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 500), 500);
            }
            if(is_null($request->sensor->sensor_id)) {
                return response()->json(['data'=>['msg'=>'sensor não encontrado']], 404);
            }
			return response()->json(ApiError::errorMessage('erro ao realizar operação de salvar', 500),  500);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Medicao $id)
    {
        $medicao = $this->medicao::with('sensor')->find($id);
        if(is_null($medicao)) return response()->json(ApiError::errorMessage('medicao não encontrada.', 404), 404);
        
        $data = ['data' => $medicao, 201];
        return response() -> json($data);
    }

    /**
     * Update the specified resource booleanrage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $validator = Validator::make($request->all(), [
            'sensor_id' => 'required|numeric|min:1',
            'data_horario' => 'required|date_format:YYYY-MM-DD hh:mm:ss',
            'valor' => 'requiredIf($request->Sensor()->tipo->temperatura)|digits_between:-100,100',
            'valor' => 'requiredIf($request->Sensor()->tipo->luminosidade)|digits_between:0,100',
            'valor' => 'requiredIf($request->Sensor()->tipo->presenca)|numeric|boolean',
            'valor' => 'requiredIf($request->Sensor()->tipo->magnetico)|numeric|boolean',
        ]);

        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        try {
            $medicaodata = $request->all();
            $medicao = $this->medicao->find($id);
            $medicao->update($medicaodata);

			$return = ['data' => ['msg' => 'medicao atualizada com sucesso.']];
			return response()->json($return, 201);
		} catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 500),  500);
			}
			return response()->json(ApiError::errorMessage('erro ao realizar operação de atualizar', 500), 500);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medicao $id)
    {
        try {
            
            $id->delete();
            return response()-> json(['data'=> ['msg'=> 'medicao: '.$id->id. ' deletada com sucesso.']],200);

		}catch (\Exception $e) {
			if(config('app.debug')) {
				return response()->json(ApiError::errorMessage($e->getMessage(), 500),  500);
			}
			return response()->json(ApiError::errorMessage('erro ao realizar operação de deletar', 500),  500);
		}
    }
}
