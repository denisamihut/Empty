<?php


return [
    'conceptTypes' => [
        'I' => 'Ingreso',
        'E' => 'Egreso',
    ],
    'roomStatus' => [
        'D' => 'Disponible',
        'O' => 'Ocupado',
        'M' => 'Mantenimiento',
    ],
    'roomStatusColor' => [
        'Disponible' => 'bg-green-success',
        'Ocupado' => 'bg-red-500',
        'Mantenimiento' => 'bg-yellow-corp',
    ],
    'roomStatusIcon' => [
        'Disponible' => 'fas fa-check-circle',
        'Ocupado' => 'fas fa-sign-out-alt',
        'Mantenimiento' => 'fas fa-hand-sparkles',
    ],
    'roomTextStatus' => [
        'Disponible' => ' Check-In',
        'Ocupado' => ' Check-Out',
        'Mantenimiento' => ' Cambiar Estado',
    ],
    'bookingStatus' => [
        'P' => 'Pendiente',
        'C' => 'Confirmado',
        'A' => 'Anulado',
    ],
    'processStatus' => [
        'P' => 'Pendiente',
        'C' => 'Confirmado',
        'A' => 'Anulado',
        'PyC' => 'Pendiente y Cancelado',
        'PyNC' => 'Pendiente y No Cancelado',
        'R' => 'Reservado',
    ],
    'checkin_hour' => 14,
    'checkin_minute' => 0,
    'checkout_hour' => 12,
    'checkout_minute' => 0,
    'paymentType' => [
        'E' => 'Efectivo',
        'V' => 'Visa',
        'D' => 'Depósito o Transferencia',
        'P' => 'PLIN',
        'Y' => 'YAPE',
        'O' => 'Otros',
    ],

    'generalConcepts' => [1, 2, 3, 4, 5, 6],
    'generalPayments' => [1, 2, 3, 4]
];