<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    public function run()
    {
        if (!Store::where('name', 'Sample Store')->exists()) {
            Store::create([
                'name' => 'Sample Store',
                'affiliate_provider_id' => AffiliateProvider::where('name', 'cuelinks')->first()->id,
                'icon' => 'stores/sample/icon.png',
                'logo' => 'stores/sample/logo.png',
                'banner' => 'stores/sample/banner.png',
                'about_store' => 'A sample store for testing.',
                'terms_and_conditions' => 'Sample T&C.',
                'label' => 'Popular',
                'cashback' => 5.00,
                'active' => true,
            ]);
        }
    }
}