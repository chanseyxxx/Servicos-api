<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentController extends Controller
{
    /**
     * Exibe uma lista de agendamentos, filtrados por data se o parâmetro de data for fornecido.
     */
    public function index(Request $request)
    {
        // Obtém o parâmetro de data da query string
        $date = $request->query('date');

        // Inicializa a consulta com o relacionamento 'service'
        $query = Appointment::with('service');

        // Aplica o filtro de data se o parâmetro 'date' for fornecido
        if ($date) {
            // Filtra os agendamentos pela data (ignorando a parte da hora)
            $query->whereDate('datetime', $date);
        }

        // Executa a consulta e obtém os agendamentos
        $appointments = $query->get();

        // Retorna a lista de agendamentos em formato JSON
        return response()->json($appointments);
    }

    /**
     * Mostra os serviços disponíveis para criar um novo agendamento.
     */
    public function create()
    {
        // Busca todos os serviços disponíveis
        $services = Service::all();

        // Retorna a lista de serviços em formato JSON
        return response()->json($services);
    }

    /**
     * Armazena um novo agendamento.
     */
    public function store(StoreAppointmentRequest $request)
    {
        // Valida os dados da requisição
        $validated = $request->validated();

        // Cria um novo agendamento com os dados validados
        $appointment = Appointment::create($validated);

        // Retorna o agendamento criado em formato JSON com status 201 (Created)
        return response()->json($appointment, Response::HTTP_CREATED);
    }

    /**
     * Exibe um agendamento específico.
     */
    public function show($id)
    {
        // Busca o agendamento pelo ID com o serviço relacionado
        $appointment = Appointment::with('service')->find($id);

        // Verifica se o agendamento existe
        if (!$appointment) {
            return response()->json(['message' => 'Agendamento não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        // Retorna o agendamento encontrado em formato JSON
        return response()->json($appointment);
    }

    /**
     * Mostra o formulário para editar um agendamento específico.
     */
    public function edit($id)
    {
        // Busca o agendamento pelo ID
        $appointment = Appointment::find($id);

        // Verifica se o agendamento existe
        if (!$appointment) {
            return response()->json(['message' => 'Agendamento não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        // Busca todos os serviços disponíveis
        $services = Service::all();

        // Retorna o agendamento e os serviços em formato JSON
        return response()->json([
            'appointment' => $appointment,
            'services' => $services,
        ]);
    }

    /**
     * Atualiza um agendamento específico.
     */
    public function update(UpdateAppointmentRequest $request, $id)
    {
        // Busca o agendamento pelo ID
        $appointment = Appointment::find($id);

        // Verifica se o agendamento existe
        if (!$appointment) {
            return response()->json(['message' => 'Agendamento não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        // Valida os dados da requisição
        $validated = $request->validated();

        // Atualiza o agendamento com os dados validados
        $appointment->update($validated);

        // Retorna uma mensagem de sucesso e o agendamento atualizado em formato JSON
        return response()->json([
            'message' => 'Agendamento atualizado com sucesso.',
            'appointment' => $appointment
        ]);
    }

    /**
     * Remove um agendamento específico.
     */
    public function destroy($id)
    {
        // Busca o agendamento pelo ID
        $appointment = Appointment::find($id);

        // Verifica se o agendamento existe
        if (!$appointment) {
            return response()->json(['message' => 'Agendamento não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        // Remove o agendamento
        $appointment->delete();

        // Retorna uma resposta sem conteúdo (status 204)
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
