<?php

namespace App\Http\Controllers;

use App\Services\UrlRouterService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UrlRouterController{

    public function create(Request $request, UrlRouterService $service){
        $validated = $request->validate([
            'target_url' => ['required', 'url'],
            'valid_to' => ['nullable','date']
        ]);       
        return response()->json(
            $service->updateOrCreateRoute(targetUrl: $validated['target_url'], validTo: $validated['valid_to'] ?? null)
        );
    }

    public function redirect(string $slug, UrlRouterService $service){    
        if (!preg_match('/^[A-Za-z]{3}-\d+$/', $slug)) {
            abort(404);
        }
        $redirectUrl = $service->getRedirect($slug);
        return redirect()->away($redirectUrl);
    }

    public function deactivate(Request $request, UrlRouterService $service){
        $validated = $request->validate([
            'slug' => ['required', 'string']
        ]);       
        if (!preg_match('/^[A-Za-z]{3}-\d+$/', $validated['slug'])) {
            abort(404);
        }
        return response()->json($service->deactRoute($validated['slug']));
    }

    public function statistic(string $slug, UrlRouterService $service){    
        if (!preg_match('/^[A-Za-z]{3}-\d+$/', $slug)) {
            abort(404);
        }
        return response()->json($service->getStatistic(slug: $slug));
    }



}