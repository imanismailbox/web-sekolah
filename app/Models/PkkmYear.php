<?php

namespace App\Models;

use App\Models\Concerns\LogsModelActivity;
use Database\Factories\PkkmYearFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['year', 'title', 'slug', 'description', 'content', 'is_published'])]
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

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('is_published', true);
    }

    /**
     * Ringkasan jumlah komponen, indikator, dan bukti (relasi harus sudah dimuat).
     *
     * @return array{components: int, indicators: int, evidence: int, filled_evidence: int}
     */
    public function summary(): array
    {
        $indicators = $this->components->flatMap->items->flatMap->indicators;
        $evidence = $indicators->flatMap->evidence;

        return [
            'components' => $this->components->count(),
            'indicators' => $indicators->count(),
            'evidence' => $evidence->count(),
            'filled_evidence' => $evidence->filter(fn (PkkmEvidence $item): bool => $item->isFilled())->count(),
        ];
    }
}
