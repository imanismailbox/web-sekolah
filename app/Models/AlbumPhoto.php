<?php

namespace App\Models;

use App\Models\Concerns\LogsModelActivity;
use Database\Factories\AlbumPhotoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['album_id', 'image', 'caption', 'sort'])]
class AlbumPhoto extends Model
{
    /** @use HasFactory<AlbumPhotoFactory> */
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
     * @return BelongsTo<Album, $this>
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function isVideo(): bool
    {
        return strtolower(pathinfo($this->image, PATHINFO_EXTENSION)) === 'mp4';
    }
}
