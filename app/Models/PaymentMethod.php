<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'active',
        'config',
    ];

    protected $casts = [
        'active' => 'boolean',
        'config' => 'array',
    ];

    // Helper: teks status
    public function getStatusTextAttribute(): string
    {
        return $this->active ? 'Aktif' : 'Nonaktif';
    }

    // Helper: ambil deskripsi singkat dari config (jika ada)
    public function getDescriptionAttribute(): string
    {
        if (is_array($this->config)) {
            return $this->config['info'] ?? $this->config['description'] ?? $this->config['bank'] ?? '-';
        }
        return '-';
    }

    // Scope: ambil yang aktif
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
