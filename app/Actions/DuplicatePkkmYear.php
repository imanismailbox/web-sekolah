<?php

namespace App\Actions;

use App\Models\PkkmYear;
use Illuminate\Support\Facades\DB;

/**
 * Copies the PKKM instrument (components, items, indicators) of one year into a new year.
 * Evidence is intentionally not copied: every year needs its own proof documents.
 */
class DuplicatePkkmYear
{
    public function handle(PkkmYear $source, int $year): PkkmYear
    {
        return DB::transaction(function () use ($source, $year): PkkmYear {
            $source->load('components.items.indicators');

            $target = PkkmYear::query()->create([
                'year' => $year,
                'title' => str_replace((string) $source->year, (string) $year, $source->title),
                'slug' => str_replace((string) $source->year, (string) $year, $source->slug),
                'description' => $source->description,
                'is_published' => false,
            ]);

            foreach ($source->components as $component) {
                $newComponent = $target->components()->create(
                    $component->only(['code', 'name', 'sort']),
                );

                foreach ($component->items as $item) {
                    $newItem = $newComponent->items()->create(
                        $item->only(['code', 'name', 'sort']),
                    );

                    foreach ($item->indicators as $indicator) {
                        $newItem->indicators()->create(
                            $indicator->only(['number', 'description', 'expected_evidence', 'sort']),
                        );
                    }
                }
            }

            return $target;
        });
    }
}
