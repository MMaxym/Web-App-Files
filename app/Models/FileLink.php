<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\FileLinkType;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileLink extends Model
{
    use HasFactory, SoftDeletes;

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
        'type' => FileLinkType::class,
        'deleted_at' => 'datetime',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public static function generateToken(): string
    {
        return bin2hex(random_bytes(16));
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }
}
