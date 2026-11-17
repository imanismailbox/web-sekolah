<?php

namespace App\Models;

use App\Models\Concerns\LogsModelActivity;
use Database\Factories\PkkmYearFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['year', 'title', 'slug', 'description', 'is_published'])]
class PkkmYear extends Model
{
    /** @use HasFactory<PkkmYearFactory> */
    use HasFactory, LogsModelActivity;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    /**
     * @return HasMany<PkkmComponent, $this>
     */
    public function components(): HasMany
    {
        return $this->hasMany(PkkmComponent::class)->orderBy('sort');
    }
}
