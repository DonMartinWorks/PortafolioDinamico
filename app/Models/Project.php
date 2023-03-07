<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'video_link', 'url', 'repo_url'];

    protected function imageUrl(): Attribute
    {
        # Si el proyecto no tiene imagen toma la imagen por defecto para mostrar en la vista.
        return Attribute::make(
            get: fn () => Storage::disk('projects')->url($this->image ?? 'default-img-project.jpg'),
        );
    }

    //Reglas para el formato de los videos de youtube
    protected function videoCode(): Attribute
    {
        return Attribute::make(
            get: fn () => str($this->video_link)->contains('watch?v=')
                ? str($this->video_link)->between('watch?v=', '&')
                : str($this->video_link)->after('youtu.be/'),
        );
    }
}
