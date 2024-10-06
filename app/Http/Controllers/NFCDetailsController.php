<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;
use App\Models\FrontFAQs;
use App\Models\NfcDetails;

class NFCDetailsController extends Controller
{
    public function showNFCDetailsForm()
    {
        $setting = Setting::all()->pluck('value', 'key');
        $faqs =  FrontFAQs::first();

        $view = view('front.nfc_details', compact('setting', 'faqs'));

        return $view;
    }

    public function storeNFCDetails(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'card_id' => 'required|unique:nfc_details,card_id',
                'business_name' => 'required',
                'issued_at' => 'nullable|date',
            ]);

            NfcDetails::create($validatedData);

            return redirect()->route('nfc.details.form')
                             ->with('success', 'NFC Details added successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('nfc.details.form')
                             ->withErrors($e->errors())
                             ->withInput();
        } catch (\Exception $e) {
            return redirect()->route('nfc.details.form')
                             ->with('error', 'An error occurred while adding NFC Details')
                             ->withInput();
        }
    }
}
