<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public ?string $tagline;

    public ?string $logo;

    public ?string $favicon;

    public ?string $address;

    public ?string $phone;

    public ?string $email;

    public ?string $whatsapp;

    public ?string $maps_embed;

    public ?string $facebook;

    public ?string $instagram;

    public ?string $youtube;

    public ?string $tiktok;

    public ?string $headmaster_name;

    public ?string $headmaster_photo;

    public ?string $headmaster_greeting;

    public ?string $footer_text;

    public static function group(): string
    {
        return 'general';
    }

    /**
     * Nomor WhatsApp dalam format internasional untuk tautan wa.me (0812... menjadi 62812...).
     */
    public function whatsappNumber(): ?string
    {
        $number = preg_replace('/\D+/', '', (string) $this->whatsapp);

        if ($number === '') {
            return null;
        }

        return str_starts_with($number, '0') ? '62'.substr($number, 1) : $number;
    }
}
