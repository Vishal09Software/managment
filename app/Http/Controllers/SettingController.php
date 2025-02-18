<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('admin.setting.general', compact('settings'));
    }

    public function update(Request $request)
    {
        //  $request->all();
        $request->validate([
            'business_name' => 'required',
            'business_phone' => 'required',
            'business_email' => 'required',
            'business_address' => 'required',
            'gst_number' => 'required',
            'business_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bank_name' => 'required',
            'account_no' => 'required',
            'ifsc_code' => 'required',
            'account_holder_name' => 'required',
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
        }
        $setting->business_name = $request->business_name;
        $setting->business_phone = $request->business_phone;
        $setting->business_email = $request->business_email;
        $setting->business_address = $request->business_address;
        $setting->gst_number = $request->gst_number;
        $setting->bank_name = $request->bank_name;
        $setting->account_no = $request->account_no;
        $setting->ifsc_code = $request->ifsc_code;
        $setting->account_holder_name = $request->account_holder_name;
        if ($request->hasFile('business_logo')) {
            // Delete old logo if exists
            if ($setting->business_logo && file_exists(public_path('images/settings/' . $setting->business_logo))) {
                unlink(public_path('images/settings/' . $setting->business_logo));
            }

            $file = $request->file('business_logo');
            $filename =  uniqid() . '.' . $file->getClientOriginalExtension();

            // Create directory if it doesn't exist
            $path = public_path('images/settings');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file->move($path, $filename);
            $setting->business_logo = $filename;
        }
        $setting->save();
        return redirect()->route('settings.index')->with('success', 'Settings updated successfully');
    }

    public function profile()
    {
        return view('profile');
    }






}
