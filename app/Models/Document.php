<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'file_path', 'user_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'document_permissions')
            ->withPivot('can_view', 'can_edit', 'can_delete')
            ->as('permissions')
            ->withTimestamps();
    }


    public function permissions()
    {
        return $this->hasMany(DocumentPermission::class);
    }
}
