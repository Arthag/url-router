<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


#[Fillable(['target_url', 'slug', 'click_counter','valid_to'])]

class UrlRoutes extends Model
{
    use HasFactory, Notifiable;
    
}
