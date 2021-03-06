<?php

use Illuminate\Database\Seeder;

use W4P\Models\Setting;
use W4P\Models\Project;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class SettingsTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::set('pwd', Hash::make('testtest'));
        Setting::set('platform.name', 'Open Knowledge');
        Setting::set('platform.analytics-id', '');
        Setting::set('platform.mollie-key', '');

        Project::create([
            'title' => "Test project",
            'brief' => "Test project description",
            'description' => "Long description",
            'video_url' => "",
            'starts_at' => Carbon::now(),
            'ends_at' => Carbon::now()->addMonth()
        ]);

        Setting::set('organisation.name', 'Organisation Name');
        Setting::set('organisation.description', 'This is a short description');
        Setting::set('organisation.website', 'http://website.com');
        Setting::set('organisation.valid', 'true');

        Setting::set('email.host', '127.0.0.1');
        Setting::set('email.port', '1025');
        Setting::set('email.username', '');
        Setting::set('email.password', '');
        Setting::set('email.encryption', '');
        Setting::set('email.from', 'test@mail.okfnbe');
        Setting::set('email.name', 'Test mail');
        Setting::set('email.valid', 'true');

        Setting::set('setup.complete', 'done');
    }
}
