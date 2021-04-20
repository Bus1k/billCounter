<?php
namespace App\Repositories;


use App\Models\Settings;
use Illuminate\Support\Facades\Auth;

class SettingsRepository
{
    private Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function getAll()
    {
        return $this->settings->where('user_id', Auth::id())->get();
    }

    public function getByName(string $name)
    {
        return $this->settings
                    ->where('user_id', Auth::id())
                    ->where('name', $name)
                    ->first();
    }

    public function set(string $name, string $value)
    {
        return $this->settings->updateOrCreate(
            ['name' => $name, 'user_id' => Auth::id()],
            ['value' => $value]
        );
    }
}
