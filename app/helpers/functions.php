<?php

if (!function_exists('successResponse')) {
    function successResponse($data = null, $message = 'Success', $code = 200)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ], $code);
        }
        return back()->with('success', $message);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse($message = 'Error', $errors = [], $code = 400)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => $message,
                'errors' => $errors
            ], $code);
        }
        return back()->withErrors($errors)->with('error', $message);
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd M Y')
    {
        return $date ? \Carbon\Carbon::parse($date)->translatedFormat($format) : '-';
    }
}

if (!function_exists('getRoleName')) {
    function getRoleName($role)
    {
        return match ($role) {
            'admin' => 'Administrator',
            'officer' => 'Petugas Lapangan',
            'resident' => 'Warga',
            default => ucfirst($role)
        };
    }
if (!function_exists('formatRupiah')) {
    function formatRupiah($amount) {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
}