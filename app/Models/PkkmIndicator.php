<?php

namespace App\Models;

use App\Models\Concerns\LogsModelActivity;
use Database\Factories\PkkmIndicatorFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['pkkm_item_id', 'number', 'description', 'expected_evidence', 'sort'])]
class PkkmIndicator extends Model
{
    /** @use HasFactory<PkkmIndicatorFactory> */
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
     * @return BelongsTo<PkkmItem, $this>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(PkkmItem::class, 'pkkm_item_id');
    }

    /**
     * @return HasMany<PkkmEvidence, $this>
     */
    public function evidence(): HasMany
    {
        return $this->hasMany(PkkmEvidence::class)->orderBy('sort');
    }
}
