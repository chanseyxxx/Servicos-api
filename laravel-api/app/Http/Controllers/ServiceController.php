<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Retorna todos os serviços
        $services = Service::all();
        return response()->json($services);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreServiceRequest $request)
    {
        // Valida e cria um novo serviço
        $validatedData = $request->validated();
        $service = Service::create($validatedData);
        return response()->json($service, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            // Retorna um serviço específico
            $service = Service::findOrFail($id);
            return response()->json($service);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateServiceRequest $request, $id)
    {
        try {
            // Valida e atualiza um serviço existente
            $validatedData = $request->validated();
            $service = Service::findOrFail($id);
            $service->update($validatedData);
            return response()->json($service);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Exclui um serviço específico
            $service = Service::findOrFail($id);
            $service->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Search for services by name and/or type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $name = $request->input('name');
        $type = $request->input('type');
    
        // Inicia a consulta
        $servicesQuery = Service::query();
    
        // Aplica filtro por nome se fornecido
        if (!empty($name)) {
            $servicesQuery->where('name', 'like', '%' . $name . '%');
        }
    
        // Aplica filtro por tipo se fornecido
        if (!empty($type)) {
            $servicesQuery->where('type', 'like', '%' . $type . '%');
        }
    
        // Executa a consulta e obtém os resultados
        $services = $servicesQuery->get();
    
        // Verifica se há resultados
        if ($services->isEmpty()) {
            return response()->json(['error' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }
    
        return response()->json(['data' => $services]);
    }
    
    

}
