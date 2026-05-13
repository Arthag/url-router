<?php

namespace App\Services;


use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\UrlRoutes;
use Carbon\Carbon;
use Illuminate\Support\Str;



class UrlRouterService
{
    public function updateOrCreateRoute(string $targetUrl, ?string $validTo = null){
        $slugPrefix = Str::random('3');
        $validToNormalized = $validTo ? Carbon::createFromFormat('Y-m-d H:i', $validTo) : null;
        $entry = UrlRoutes::firstOrCreate([
            'target_url' => $targetUrl
        ],[
            'target_url' => $targetUrl,
            'valid_to' => $validToNormalized,
            'slug' => $slugPrefix.'-tmp'
        ]);

        $slugPrefix = Str::random('3');
        //just set the slug if it is a new one, keep slugs already in use
        if (str_ends_with($entry->slug, '-tmp')) {
            $entry->slug = $slugPrefix.'-'.$entry->id;
        }
        $entry->valid_to = $validToNormalized;
        $entry->save();
        return $entry;
    }

    public function getRedirect(string $slug){
        $entry = UrlRoutes::where('slug', $slug)
            ->where(function ($query) {
                $query->whereNull('valid_to')
                    ->orWhere('valid_to', '>', now());
            })
            ->firstOrFail();
        $entry->increment('click_counter');
        return $entry->target_url;
    }

    public function deactRoute(string $slug){
        $validTo = now();
        $entry = UrlRoutes::where('slug', $slug)
            ->firstOrFail();
        $entry->valid_to = $validTo;
        $entry->save();
        return array('slug' => $slug, 'valid_to' => $validTo->format('Y-m-d H:i:s'));  
    }

    public function getStatistic(string $slug){
        $entry = UrlRoutes::where('slug', $slug)
            ->firstOrFail();
        return $entry->toArray();

    }
}    