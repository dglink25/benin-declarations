<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model{
    use HasFactory;

    protected $table = 'medias';

    protected $fillable = [
        'declaration_id', 
        'type', 
        'path'];

    public function declaration()
    {
        return $this->belongsTo(Declaration::class);
    }
}
