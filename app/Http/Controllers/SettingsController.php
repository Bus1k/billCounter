<?php
namespace App\Http\Controllers;


use App\Repositories\SettingsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SettingsController extends Controller
{
    private const RULES = [
        'clientId'     => 'required|string|min:10|max:150',
        'secret'       => 'required|string|min:10|max:150',
        'refreshToken' => 'required|string|min:10|max:150',
        'folderId'     => 'required|string|min:10|max:150',
    ];

    private SettingsRepository $settings;

    public function __construct(SettingsRepository $settings)
    {
        $this->middleware('auth');
        $this->settings = $settings;
    }

    public function index()
    {
        $googleDrive = json_decode($this->settings->getByName('GOOGLE_DRIVE_CONFIG'), true);

        return view('settings.settings', [
            'google_drive' => [
                'clientId'     => $googleDrive['clientId'],
                'refreshToken' => $googleDrive['refreshToken'],
                'folderId'     => $googleDrive['folderId'],
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(self::RULES);

        $data = [
            'clientId' => $request->clientId,
            'folderId' => $request->folderId,
            'secret'   => Crypt::encryptString($request->secret),
            'refreshToken' => $request->refreshToken
        ];

        $this->settings->set('GOOGLE_DRIVE_CONFIG', json_encode($data));

        return redirect(route('index_settings'))->with('success', 'Settings saved successfully');
    }

}
