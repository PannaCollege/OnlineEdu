<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('response_success')) {
    function response_success(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['success' => true]);
    }
}

if (!function_exists('response_unauthorized')) {
    function response_unauthorized(): \Illuminate\Http\JsonResponse
    {
        return response()->json(data: ['message' => 'unauthorized'], status: 401);
    }
}

if (!function_exists('response_error')) {
    function response_error(string $message, int $status): \Illuminate\Http\JsonResponse
    {
        return response()->json(['message' => $message], status: $status);
    }
}

if (!function_exists('response_ok')) {
    function response_ok(mixed $message, int $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json(data: $message, status: $status);
    }
}

if (!function_exists('space')) {
    function space(): string
    {
        return app()->isProduction() ? 's3' : 'public';
    }
}

if (!function_exists('get_image_url')) {
    function get_image_url(string $path): string
    {
        return Storage::disk(space())->url($path);
    }
}
