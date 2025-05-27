<?php

use Illuminate\Database\Seeder;
use App\Models\Paciente;
use Illuminate\Support\Facades\DB;

class PreparePacienteData extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // 1. Identificar pacientes duplicados por email
            $duplicates = Paciente::select('email')
                ->groupBy('email')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('email');

            // 2. Actualizar emails duplicados
            foreach ($duplicates as $email) {
                $pacientes = Paciente::where('email', $email)->get();
                $counter = 1;

                foreach ($pacientes as $paciente) {
                    if ($counter > 1) {
                        $newEmail = $this->generateUniqueEmail($email, $paciente->user_id);
                        $paciente->email = $newEmail;
                        $paciente->save();
                    }
                    $counter++;
                }
            }

            // 3. Hacer lo mismo para teléfono y usuario si es necesario
            $this->handleUniqueField('telefono');
            $this->handleUniqueField('usuario');
        });
    }

    protected function generateUniqueEmail($originalEmail, $userId)
    {
        $parts = explode('@', $originalEmail);
        $localPart = $parts[0];
        $domain = $parts[1] ?? '';

        return "{$localPart}+nut{$userId}@{$domain}";
    }

    protected function handleUniqueField($field)
    {
        $duplicates = Paciente::select($field)
            ->whereNotNull($field)
            ->groupBy($field)
            ->havingRaw('COUNT(*) > 1')
            ->pluck($field);

        foreach ($duplicates as $value) {
            $pacientes = Paciente::where($field, $value)->get();
            $counter = 1;

            foreach ($pacientes as $paciente) {
                if ($counter > 1) {
                    $newValue = "{$value}_{$paciente->user_id}";
                    $paciente->$field = $newValue;
                    $paciente->save();
                }
                $counter++;
            }
        }
    }
}
