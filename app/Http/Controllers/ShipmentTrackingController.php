<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;
use App\Models\FrontFAQs;
use Illuminate\Support\Facades\Cache;

class ShipmentTrackingController extends Controller
{
    private function login()
    {
        $cachedToken = Cache::get('shipping_service_token');

        if ($cachedToken) {
            return $cachedToken;
        }

        $loginUrl = env('AJ_EX_LOGIN');
        $username = env('AJ_EX_USERNAME');
        $password = env('AJ_EX_PASSWORD');

        $response = Http::post($loginUrl, [
            'username' => $username,
            'password' => $password,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['accessToken']) && isset($data['tokenType'])) {
                return $data['tokenType'] . ' ' . $data['accessToken'];
            }
        }

        throw new \Exception('Failed to login to shipping service');
    }

    public function showTrackingForm()
    {
        $setting = Setting::all()->pluck('value', 'key');
        $faqs =  FrontFAQs::first();

        $view = view('front.track_shipment', compact('setting', 'faqs'));

        return $view;
    }

    public function trackShipment(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string',
        ]);

        $setting = Setting::all()->pluck('value', 'key');
        $faqs =  FrontFAQs::first();

        try {
            $token = $this->login();

            $trackingNumber = $request->input('tracking_number');
            $apiUrl = env('AJ_EX_TRACKING') . "/{$trackingNumber}";

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $token
            ])->get($apiUrl);

            if ($response->successful()) {
                $trackingResult = $response->json();

                return redirect()->route('track.shipment.form')
                 ->with([
                     'success' => 'sucessful',
                     'trackingResult' => $trackingResult,
                     'setting' => $setting,
                     'faqs' => $faqs,
                 ]);
            } else {
                return redirect()->route('track.shipment.form')
                 ->with([
                     'error' => 'error',
                     'trackingResult' => $trackingResult,
                     'setting' => $setting,
                     'faqs' => $faqs,
                 ]);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
