<?php

namespace App\Models;

use App\Enums\MenuItemType;
use App\Models\Concerns\LogsModelActivity;
use Database\Factories\MenuItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;

#[Fillable(['parent_id', 'label', 'type', 'target_id', 'url', 'route_name', 'open_in_new_tab', 'sort', 'is_active'])]
class MenuItem extends Model
{
    /** @use HasFactory<MenuItemFactory> */
    use HasFactory, LogsModelActivity;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => MenuItemType::class,
            'open_in_new_tab' => 'boolean',
            'is_active' => 'boolean',
            'sort' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<MenuItem, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany<MenuItem, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort');
    }

    /**
     * Active top-level items with their active children, ordered for rendering.
     *
     * @return Collection<int, MenuItem>
     */
    public static function tree(): Collection
    {
        return self::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort')
            ->with(['children' => fn (HasMany $query) => $query->where('is_active', true)])
            ->get();
    }

    /**
     * Resolve the final URL for this menu item based on its type.
     */
    public function url(): string
    {
        $routeName = $this->type === MenuItemType::Route
            ? $this->route_name
            : $this->type->targetRouteName();

        if ($this->type === MenuItemType::Url) {
            return $this->url ?: '#';
        }

        if (blank($routeName) || ! Route::has($routeName)) {
            return '#';
        }

        if ($this->type === MenuItemType::Route) {
            return route($routeName);
        }

        $target = $this->type->targetModel()::query()->find($this->target_id);

        return $target ? route($routeName, $target->getAttribute('slug')) : '#';
    }
}
