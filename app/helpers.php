<?php

if (!function_exists('matrikTernormalisasi')) {
    function matrikTernormalisasi($matriks, $keterangan)
    {
        foreach ($matriks as $key => $a) {
            $i=0;
            foreach ($a as $k => $b) {
                $c_val[$k][] = $a[$k][2];
                $a_val[$k][] = $a[$k][0];
            }
        }
        $c_matriks = $matriks;
        foreach ($c_matriks as $key => &$a) {
            foreach ($a as $k => &$b) {
                if ($keterangan[$k] == 'benefit') {
                    $max_c = max($c_val[$k]);
                    $temp = $b;
                    for($i=0;$i<=2;$i++){
                        $b[$i] = $temp[$i] / $max_c;
                    }
                } else if ($keterangan[$k] == 'cost') {
                    $min_a = min($a_val[$k]);
                    $temp = $b;
                    if($min_a==0){
                        $b[0] = $temp[2];
                        $b[1] = $temp[1];
                        $b[2] = $temp[0];
                    } else {
                            $b[0] = $min_a / $temp[2] == 0 ? 1 : $temp[2];
                            $b[1] = $min_a / $temp[1] == 0 ? 1 : $temp[1];
                            $b[2] = $min_a / $temp[0] == 0 ? 1 : $temp[0];
                    }

                }
            }
        }
        return $c_matriks;
    }
}

if (!function_exists('matrikTerbobot')) {
    function matrikTerbobot($matrik, $bobot)
    {
        foreach ($matrik as $key => &$a) {
            foreach ($a as $k => &$b) {
                $b[0] = $b[0] * $bobot[$k][0];
                $b[1] = $b[1] * $bobot[$k][1];
                $b[2] = $b[2] * $bobot[$k][2];
            }
        }
        return $matrik;
    }
}
if (!function_exists('idealPositif')) {
    function idealPositif($matriks)
    {
        foreach ($matriks as $key => $a) {
            foreach ($a as $k => $b) {
                $temp_a[$k][0][] = $a[$k][0];
                $temp_a[$k][1][] = $a[$k][1];
                $temp_a[$k][2][] = $a[$k][2];
            }
        }
        foreach ($temp_a as $key => $val) {
            $idealPositif[$key][0] = max($val[0]);
            $idealPositif[$key][1] = max($val[1]);
            $idealPositif[$key][2] = max($val[2]);
        }
        return $idealPositif;
    }
}
if (!function_exists('idealNegatif')) {
    function idealNegatif($matriks)
    {
        foreach ($matriks as $key => $a) {
            foreach ($a as $k => $b) {
                $temp_a[$k][0][] = $a[$k][0];
                $temp_a[$k][1][] = $a[$k][1];
                $temp_a[$k][2][] = $a[$k][2];
            }
        }
        foreach ($temp_a as $key => $val) {
            $idealNegatif[$key][0] = min($val[0]);
            $idealNegatif[$key][1] = min($val[1]);
            $idealNegatif[$key][2] = min($val[2]);
        }
        return $idealNegatif;
    }
}
if (!function_exists('dPlus')) {
    function dPlus($matriks, $idealPositif)
    {
        foreach ($matriks as $key => &$a) {
            foreach ($a as $k => &$b) {
                $b = sqrt((1 / 3) * (pow($b[0] - $idealPositif[$k][0], 2) +
                        pow($b[1] - $idealPositif[$k][1], 2) + pow($b[2] -
                            $idealPositif[$k][2], 2)));
            }
        }
        foreach ($matriks as $key => &$a) {
            $a = array_sum($a);
        }
        return $matriks;
    }
}
if (!function_exists('dMin')) {
    function dMin($matriks, $idealNegatif)
    {
        foreach ($matriks as $key => &$a) {
            foreach ($a as $k => &$b) {
                $b = sqrt((1 / 3) * (pow($b[0] - $idealNegatif[$k][0], 2) +
                        pow($b[1] - $idealNegatif[$k][1], 2) + pow($b[2] -
                            $idealNegatif[$k][2], 2)));
            }
        }
        foreach ($matriks as $key => &$a) {
            $a = array_sum($a);
        }
        return $matriks;
    }
}
if (!function_exists('nilaiPreferensi')) {
    function nilaiPreferensi($dPlus, $dMin){
        foreach ($dMin as $key => $value) {
            $nilaiPreferensi[$key] = $value / ($value + $dPlus[$key]);
        }
        return $nilaiPreferensi;
    }
}
if (!function_exists('rangking')) {
    function rangking($nilaiPreferensi){
        $arrNilaiPreferensi = (array) $nilaiPreferensi;
        arsort($arrNilaiPreferensi);

        foreach ($arrNilaiPreferensi as $key => $value) {
            $rangking[] = $key;
        }
        return $rangking;
    }
}

if (!function_exists('getKeterangan')) {
    function getKeterangan($rentalKriteria){
        foreach ($rentalKriteria as $key => $value) {
            $relation[$value['product_id']][] = $value['kriteria'] ['keterangan'];
        }
        $index = 0;
        foreach ($relation as $key => $value) {
            if($index==0){
                for ($i=0; $i < count($value); $i++) {
                    $keterangan[$i] = $value[$i];
                }
            }
            $index++;
        }
        return $keterangan;
    }
}
