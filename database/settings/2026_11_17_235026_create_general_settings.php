<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Madrasah');
        $this->migrator->add('general.tagline', null);
        $this->migrator->add('general.logo', null);
        $this->migrator->add('general.favicon', null);
        $this->migrator->add('general.address', null);
        $this->migrator->add('general.phone', null);
        $this->migrator->add('general.email', null);
        $this->migrator->add('general.whatsapp', null);
        $this->migrator->add('general.maps_embed', null);
        $this->migrator->add('general.facebook', null);
        $this->migrator->add('general.instagram', null);
        $this->migrator->add('general.youtube', null);
        $this->migrator->add('general.tiktok', null);
        $this->migrator->add('general.headmaster_name', null);
        $this->migrator->add('general.headmaster_photo', null);
        $this->migrator->add('general.headmaster_greeting', null);
        $this->migrator->add('general.footer_text', null);
    }
};
