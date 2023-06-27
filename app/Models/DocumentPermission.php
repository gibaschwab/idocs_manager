<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DocumentPermission extends Model
{
    protected $table = 'document_permissions';

    protected $fillable = ['document_id', 'user_id', 'can_view', 'can_edit', 'can_delete'];
}
