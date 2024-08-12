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
     * Exibe uma lista de todos os serviços.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    /**
     * Armazena um novo serviço.
     *
     * @param  \App\Http\Requests\StoreServiceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreServiceRequest $request)
    {
        $validatedData = $request->validated();
        $service = Service::create($validatedData);
        return response()->json($service, Response::HTTP_CREATED);
    }

    /**
     * Exibe um serviço específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $service = Service::findOrFail($id);
            return response()->json($service);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Serviço não encontrado.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Atualiza um serviço específico.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateServiceRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $service = Service::findOrFail($id);
            $service->update($validatedData);
            return response()->json($service);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Serviço não encontrado.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove um serviço específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Serviço não encontrado.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Filtra serviços por nome e/ou tipo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
{
    $name = $request->query('name');
    $type = $request->query('type');

    // Inicia a consulta
    $servicesQuery = Service::query();

    // Aplica filtro por nome se fornecido
    if ($name) {
        $servicesQuery->where('name', 'like', '%' . $name . '%');
    }

    // Aplica filtro por tipo se fornecido
    if ($type) {
        $servicesQuery->where('type', 'like', '%' . $type . '%');
    }

    // Executa a consulta e obtém os resultados
    $services = $servicesQuery->get();

    // Verifica se há resultados
    if ($services->isEmpty()) {
        return response()->json(['message' => 'Nenhum serviço encontrado.'], Response::HTTP_NOT_FOUND);
    }

    // Retorna os serviços encontrados em formato JSON
    return response()->json(['data' => $services]);
}

}
