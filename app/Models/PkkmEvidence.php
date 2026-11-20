<?php

namespace App\Models;

use App\Enums\EvidenceType;
use App\Models\Concerns\LogsModelActivity;
use Database\Factories\PkkmEvidenceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Table('pkkm_evidence')]
#[Fillable(['pkkm_indicator_id', 'label', 'type', 'url', 'file_path', 'sort'])]
class PkkmEvidence extends Model
{
    /** @use HasFactory<PkkmEvidenceFactory> */
    use HasFactory, LogsModelActivity;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => EvidenceType::class,
            'sort' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<PkkmIndicator, $this>
     */
    public function indicator(): BelongsTo
    {
        return $this->belongsTo(PkkmIndicator::class, 'pkkm_indicator_id');
    }

    /**
     * Public URL of the evidence (external link or uploaded file).
     */
    public function href(): ?string
    {
        return match ($this->type) {
            EvidenceType::File => $this->file_path ? Storage::disk('public')->url($this->file_path) : null,
            default => $this->url,
        };
    }

    /**
     * Whether this evidence slot already has an uploaded file or link.
     */
    public function isFilled(): bool
    {
        return filled($this->href());
    }
}
