<?php
    return [
        'kriteria_harga_ids' => [11,12,13,14,15],
        'kriteria_supplier_ids' => [1,2,3,4,5],
        'kriteria_harga' => ['Murah', 'Cukup Murah', 'Sedang', 'Mahal', 'Sangat Mahal'],
        'bobot' => [[0.1, 0.1, 0.3], [0.1, 0.3, 0.5], [0.3, 0.5, 0.7], [0.5, 0.7, 0.9], [0.7, 0.9, 1.0]],
        'bobot_user' => [
            1 => [0.1, 0.1, 0.3],
            2 => [0.1, 0.3, 0.5],
            3 => [0.3, 0.5, 0.7],
            4 => [0.5, 0.7, 0.9],
            5 => [0.7, 0.9, 1.0]
        ],
        'label_bobot' => [
            1 => "Tidak Penting",
            2 => "Kurang penting",
            3 => "Cukup Penting",
            4 => "Penting",
            5 => "Sangat Penting"
        ],
        'code_bobot' => [
            1 => "TP",
            2 => "KP",
            3 => "CP",
            4 => "P",
            5 => "SP"
        ]
    ];
?>
