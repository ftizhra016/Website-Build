<?php

if (!function_exists('monthOption')) {
    function monthOption()
    {
        $months = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
        return $months;
    }
}

if (!function_exists('getAvailableYears')) {
    function getAvailableYears(string $modelClass, string $dateColumn = 'created_at')
    {
        if (!class_exists($modelClass)) {
            return collect();
        }

        return $modelClass::selectRaw("YEAR($dateColumn) as year")
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
    }
}