<?php
namespace App\Http\Controllers;


use App\Repositories\SettingsRepository;

class SettingsController extends Controller
{
    private SettingsRepository $settings;

    public function __construct(SettingsRepository $settings)
    {
        $this->middleware('auth');
        $this->settings = $settings;
    }

    public function index()
    {
        $test = $this->settings->set('FILE_LOCATION_HWDP', 'kako');

        ddd($test);

        return view('settings.settings');
    }

}
