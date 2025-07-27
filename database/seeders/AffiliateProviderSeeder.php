<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AffiliateProvider;

class AffiliateProviderSeeder extends Seeder
{
    public function run()
    {
        if (!AffiliateProvider::where('name', 'cuelinks')->exists()) {
            AffiliateProvider::create([
                'name' => 'cuelinks',
                'callback_secret' => 'your-cuelinks-secret',
            ]);
        }
    }
}