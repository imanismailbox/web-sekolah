<?php

namespace App\Models;

use Database\Factories\VisitorLogFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['visitor_hash', 'visited_on', 'last_seen_at', 'hits'])]
class VisitorLog extends Model
{
    /** @use HasFactory<VisitorLogFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'last_seen_at' => 'datetime',
            'hits' => 'integer',
        ];
    }
}
