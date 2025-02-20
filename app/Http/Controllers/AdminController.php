<?php

namespace App\Http\Controllers;

use App\Enums\Settings;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        Gate::authorize('admin_panel');
    }

    public function index(Request $request)
    {
        $config = Setting::all()->mapWithKeys(fn ($model) => [$model->key => $model->value]);

        return view('admin.index', [
            'config' => $config
        ]);
    }

    public function settingsUpdate(Request $request)
    {
        $validated = $request->validate([
            'settings' => [
                'required',
                'array:' . implode(',', array_column(Settings::cases(), 'value'))
            ]
        ])['settings'];

        $rules = [];
        foreach ($validated as $key => $value) {
            $rules[$key] = Settings::from($key)->rules();
        }

        $validated = Validator::make($validated, $rules)->validate();

        try {
            DB::transaction(function () use ($validated) {
                foreach ($validated as $key => $value) {
                    Setting::updateOrCreate([
                        'key' => $key
                    ], [
                        'value' => $value
                    ]);
                }
            });

            Cache::forget('settings');
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'message' => 'There was an error saving your configuration.'
            ], 500);
        }

        return response()->json([
            'message' => 'Config saved.'
        ]);
    }
}
