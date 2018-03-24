<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['first_name', 'last_name', 'company_id', 'email', 'phone', 'creator_id'];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
