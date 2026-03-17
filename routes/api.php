<?php

use App\Models\AppInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Devuelve todas las secciones activas ordenadas (para Next.js u otras webs)
Route::get('/app-info', function () {
    return AppInfo::where('active', true)
        ->orderBy('order')
        ->get(['slug', 'title', 'img_head', 'excerpt', 'body']);
});

// Devuelve una sección específica por slug
Route::get('/app-info/{slug}', function (string $slug) {
    $info = AppInfo::where('slug', $slug)->where('active', true)->first();

    if (! $info) {
        return response()->json(['error' => 'Not found'], 404);
    }

    return $info->only(['slug', 'title', 'img_head', 'excerpt', 'body']);
});

// Devuelve los hitos (historicals con is_milestone = true)
Route::get('/milestones', function (Request $request) {
    $query = \App\Models\Historical::where('is_milestone', true)
        ->with('project:id,name');

    if ($request->has('project_id')) {
        $query->where('project_id', $request->project_id);
    }

    return $query->orderBy('event_date', 'desc')
        ->get(['id', 'project_id', 'title', 'body', 'icon', 'img', 'event_date']);
});
