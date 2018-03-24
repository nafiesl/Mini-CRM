<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'email', 'logo', 'address', 'website', 'creator_id'];

    public function nameLink()
    {
        return link_to_route('companies.show', $this->name, [$this], [
            'title' => trans(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => trans('company.company')]
            ),
        ]);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
