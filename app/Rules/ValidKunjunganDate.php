<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;
use App\Models\Agenda;

class ValidKunjunganDate implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $date = Carbon::parse($value);

        // Check 1: Is the date a weekend?
        if ($date->isWeekend()) {
            $fail('Kunjungan tidak dapat dilakukan pada hari Sabtu atau Minggu.');
            return;
        }

        // Check 2: Does an agenda already exist on this date?
        $hasAgenda = Agenda::whereDate('tanggal', $date)->exists();
        if ($hasAgenda) {
            $fail('Tanggal yang dipilih tidak tersedia karena sudah ada agenda lain.');
        }
    }
}