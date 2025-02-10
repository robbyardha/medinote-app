<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $settingData = Setting::first();

        if ($request->isMethod('get')) {
            $data = [
                'title' => 'Setting',
                'draftCount' => 40,
                'publishedCount' => 40,
                'setting' => $settingData
            ];

            return view('setting.index', $data);
        }
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name_app' => 'required',
                'email' => 'required',
                'number_phone' => 'required',
            ], [
                'name_app.required' => 'Nama Aplikasi wajib diisi',
                'email.required' => 'Email wajib diisi',
                'number_phone.required' => 'Nomor Telp wajib diisi',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {

                if ($settingData) {
                    $settingData->update([
                        'name_app' => $request->input('name_app'),
                        'email' => $request->input('email'),
                        'number_phone' => $request->input('number_phone'),
                    ]);
                } else {
                    Setting::create([
                        'name_app' => $request->input('name_app'),
                        'email' => $request->input('email'),
                        'number_phone' => $request->input('number_phone'),
                    ]);
                }

                return redirect("/setting")
                    ->with('success', 'Setting Diperbarui');
            } catch (\Exception $e) {
                return redirect("/setting")
                    ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                    ->withInput();
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSettingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
