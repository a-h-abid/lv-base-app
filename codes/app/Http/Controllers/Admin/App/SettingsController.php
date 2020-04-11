<?php

namespace App\Http\Controllers\Admin\App;

use App\Eloquents\AppSetting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\App\SettingsFormRequest;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * View Settings Form
     *
     * @return \Illuminate\Http\Response
     */
    public function form()
    {
        $settings = AppSetting::first();
        if (empty($settings)) {
            $settings = new AppSetting;
        }

        return view('admin/auth/app/settings/form', compact('settings'));
    }

    /**
     * Save Settings
     *
     * @param  \App\Http\Requests\Admin\App\SettingsFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function save(SettingsFormRequest $request)
    {
        $data = $request->validated();

        $settings = AppSetting::first();
        if (empty($settings)) {
            $settings = new AppSetting;
        }
        $settings->fill($data);
        $settings->save();

        session()->flash('flash.success', 'App Setting saved!');

        return redirect()->back();
    }
}
