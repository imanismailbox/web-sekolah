<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.background_music', null);
        $this->migrator->add('general.background_music_enabled', false);
    }
};
