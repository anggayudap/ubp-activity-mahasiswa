<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('get_date')) {
    function get_date($date = '', $format = '') {
        if ($date && $date != '0000-00-00') {
            if (!$format) {
                $format = 'd/m/Y';
            }

            $timestamp = strtotime($date);
            return date($format, $timestamp);
        }
        return false;
    }
}

if (!function_exists('get_indo_date')) {
    function get_indo_date($date = '', $format = '') {
        if ($date && $date != '0000-00-00') {
            if (!$format) {
                $format = 'd F Y';
            }

            $timestamp = strtotime($date);
            return date($format, $timestamp);
        }
        return false;
    }
}

if (!function_exists('get_date_time')) {

    function get_date_time($date = '') {
        if ($date) {
            $format = 'd/m/Y' . ' H:i';
            $timestamp = strtotime($date);
            return date($format, $timestamp);
        }
        return 'false';
    }

}
if (!function_exists('convert_date_time')) {

    function convert_date_time($date = false) {
        if ($date) {
            $format = 'd/m/Y' . ' H:i';
            return date($format, $date);
        }
        return false;
    }

}
if (!function_exists('number')) {

    function number($val, $numod = false) {
        $numod = $numod or 0;
        $value = number_format($val, $numod, ',', '.');
        return $value;
    }

}
if (!function_exists('rupiah')) {

    function rupiah($val) {
        $value = number($val);
        return 'Rp ' . $value;
    }
}
if (!function_exists('generate_code')) {
    function generate_code() {
        // 22/KS/001
        $year_code = date('y');

        $last_code = DB::select('SELECT IFNULL(MAX(SUBSTRING(a.code, -3, 3)),0) as last_code FROM permintaan a WHERE YEAR(date) = ?', [date('Y')]);

        // hapus 0 di depan angka
        $last_code = (int) $last_code[0]->last_code;
        // increment
        $last_code++;

        if ($last_code < 10) {
            $last_code = '00' . $last_code;
        } elseif ($last_code < 100) {
            $last_code = '0' . $last_code;
        }

        return $year_code . '/KS/' . $last_code;
    }
}