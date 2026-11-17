<?php

namespace App\Models;

use App\Models\Concerns\LogsModelActivity;
use Database\Factories\PkkmItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['pkkm_component_id', 'code', 'name', 'sort'])]
class PkkmItem extends Model
{
    /** @use HasFactory<PkkmItemFactory> */
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
     * @return BelongsTo<PkkmComponent, $this>
     */
    public function component(): BelongsTo
    {
        return $this->belongsTo(PkkmComponent::class, 'pkkm_component_id');
    }

    /**
     * @return HasMany<PkkmIndicator, $this>
     */
    public function indicators(): HasMany
    {
        return $this->hasMany(PkkmIndicator::class)->orderBy('sort');
    }
}
