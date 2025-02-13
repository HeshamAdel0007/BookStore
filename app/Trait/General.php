<?php

namespace App\Trait;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

trait General
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable;
    public function getActive(): string
    {
        return  $this->status  == 0 ?   'Un-Activated'   : 'Activated';
    } // End Of getActive

}// End Of Trait
