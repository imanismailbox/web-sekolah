<?php

namespace App\Models;

use App\Models\Concerns\LogsModelActivity;
use Database\Factories\PkkmComponentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['pkkm_year_id', 'code', 'name', 'sort'])]
class PkkmComponent extends Model
{
    /** @use HasFactory<PkkmComponentFactory> */
    use HasFactory, LogsModelActivity;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<PkkmYear, $this>
     */
    public function year(): BelongsTo
    {
        return $this->belongsTo(PkkmYear::class, 'pkkm_year_id');
    }

    /**
     * @return HasMany<PkkmItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(PkkmItem::class)->orderBy('sort');
    }
}
