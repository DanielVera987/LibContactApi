<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'street',
        'between_streets',
        'zip',
        'city',
        'state',
        'num_ext',
        'num_int',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
