<?php

use App\Models\Appointment;
use App\Models\Menu;
use App\Models\Setting;
use App\Models\SubMenu;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

if (!function_exists('loadMenus')) {
    function loadMenus($is_show = "")
    {
        return Menu::get_menu($is_show);
    }
}

if (!function_exists('loadSubMenus')) {
    function loadSubMenus(int $menu_id, $is_show = "")
    {
        return SubMenu::get_submenu_by_menu($menu_id, $is_show);
    }
}

if (!function_exists('loadPermissionByUrl')) {
    function loadPermissionByUrl(string $url, $length = 0)
    {
        return DB::table("permissions")
            ->select("name")
            ->whereRaw("LEFT(name, '$length')='$url'")
            ->get();
    }
}

if (!function_exists('loadPermissionByUrlLite')) {
    function loadPermissionByUrlLite(string $url, $length = 0)
    {
        return DB::table("permissions")
            ->select("name")
            ->whereRaw("substr(name, 1, ?) = ?", [$length, $url])
            ->get();
    }
}


function requiredFieldLabel($label)
{
    return $label . ' <span style="color: red;">*</span>';
}


function generateQueueNumber()
{
    $dateToday = Carbon::now()->format('Y-m-d');

    $latestAppointment = Appointment::whereDate('created_at', $dateToday)
        ->orderBy('queue_number', 'desc')
        ->first();

    if ($latestAppointment) {
        $latestQueueNumber = $latestAppointment->queue_number;
        $currentNumber = (int) substr($latestQueueNumber, 3);
        $newQueueNumber = str_pad($currentNumber + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $newQueueNumber = '0001';
    }

    $queueNumber = 'QN-' . $newQueueNumber;

    return $queueNumber;
}

function getAuthenticationAPILogin($email = null, $password = null)
{
    $client = new Client();
    $url = 'http://recruitment.rsdeltasurya.com/api/v1/auth';

    try {
        if (is_null($email) || is_null($password)) {
            $setting = Setting::first();
            if (!$setting) {
                return ['error' => 'Email atau Password tidak ditemukan dalam pengaturan.'];
            }

            $email = $setting->email;
            $password = $setting->number_phone;
        }

        $response = $client->post($url, [
            'form_params' => [
                'email' => $email,
                'password' => $password
            ]
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);
        return $data;
    } catch (RequestException $e) {
        Log::error("API request failed: " . $e->getMessage());
        return ['error' => 'Terjadi kesalahan saat melakukan request API.'];
    }
}

function getMedicinesData($accessToken = null)
{
    if (is_null($accessToken)) {
        $authAPI = getAuthenticationAPILogin();
        if (isset($authAPI['error'])) {
            return ['error' => $authAPI['error']];
        }
        $accessToken = $authAPI['access_token'];
    }

    $client = new Client();
    $url = 'http://recruitment.rsdeltasurya.com/api/v1/medicines';

    try {
        $response = $client->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept'        => 'application/json',
            ]
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);

        return $data;
    } catch (RequestException $e) {
        Log::error("API request failed: " . $e->getMessage());
        return ['error' => 'Terjadi kesalahan saat mengambil data obat: ' . $e->getMessage()];
    }
}

function getMedicineDetail($id, $accessToken = null)
{
    try {
        $client = new Client();
        $url = "http://recruitment.rsdeltasurya.com/api/v1/medicines/$id/prices";

        if (is_null($accessToken)) {
            $authAPI = getAuthenticationAPILogin();
            if (isset($authAPI['error'])) {
                return ['error' => $authAPI['error']];
            }
            $accessToken = $authAPI['access_token'];
        }

        $response = $client->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/json',
            ]
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);

        return $data;
    } catch (\Exception $e) {
        return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
    }
}
