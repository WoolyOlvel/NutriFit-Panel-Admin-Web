<?php

namespace App\Observers;

use App\Models\Paciente;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PacienteObserver
{
    // Campos que deben sincronizarse
    protected $syncFields = [
        'foto',
        'nombre',
        'apellidos',
        'email',
        'telefono',
        'genero',
        'usuario',
        'enfermedad',
        'ciudad',
        'localidad',
        'edad',
        'fecha_nacimiento'
    ];

    public function updated(Paciente $pacienteOriginal)
    {
        // Verificar si este es un paciente original (no duplicado)
        if ($this->esPacienteOriginal($pacienteOriginal)) {
            $this->actualizarPacientesDuplicados($pacienteOriginal);
        }
    }

    protected function esPacienteOriginal(Paciente $paciente)
    {
        // Un paciente es original si no tiene sufijo _nutXX en teléfono o usuario
        return !Str::contains($paciente->telefono ?? '', '_nut') &&
               !Str::contains($paciente->usuario ?? '', '_nut');
    }

    protected function actualizarPacientesDuplicados(Paciente $pacienteOriginal)
    {
        try {
            Log::info("Iniciando sincronización de duplicados para paciente: {$pacienteOriginal->Paciente_ID}");

            // Obtener todos los pacientes duplicados (mismo email pero con sufijo)
            $duplicados = Paciente::where('email', $pacienteOriginal->email)
                ->where('Paciente_ID', '!=', $pacienteOriginal->Paciente_ID)
                ->get();

            $datosActualizados = [];
            foreach ($this->syncFields as $field) {
                if ($pacienteOriginal->isDirty($field)) {
                    $datosActualizados[$field] = $pacienteOriginal->$field;
                }
            }

            if (!empty($datosActualizados)) {
                Log::info("Campos a actualizar en duplicados: " . json_encode($datosActualizados));

                foreach ($duplicados as $duplicado) {
                    try {
                        $duplicado->update($datosActualizados);
                        Log::info("Paciente duplicado actualizado: {$duplicado->Paciente_ID}");
                    } catch (\Exception $e) {
                        Log::error("Error actualizando paciente duplicado {$duplicado->Paciente_ID}: " . $e->getMessage());
                    }
                }
            } else {
                Log::info("No hay cambios relevantes para sincronizar con duplicados");
            }
        } catch (\Exception $e) {
            Log::error("Error en actualizarPacientesDuplicados: " . $e->getMessage());
        }
    }
}
