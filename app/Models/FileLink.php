<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id',
        'type',
        'token',
        'is_active',
        'views_count',
    ];

    protected $casts = [
        'file_id' => 'integer',
        'is_active' => 'boolean',
        'views_count' => 'integer',
        'type' => 'enum',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}
