<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Display a report of contacts grouped by country.
     */
    public function contactsByCountry()
    {
        // 1. Get contact counts per country_code from the database.
        // We only count non-soft-deleted contacts.
        $contactsByCountryCode = Contact::select('country_code', DB::raw('count(*) as total'))
            ->whereNull('deleted_at') // Only count active contacts
            ->groupBy('country_code')
            ->orderBy('total', 'desc') // Order by count, highest first
            ->get();

        // 2. Fetch country names for the country codes from the external API.
        // This is necessary because our database only stores the code, not the name.
        $countryCodesInReport = $contactsByCountryCode->pluck('country_code')->unique()->toArray();
        $countryNames = []; // To store country_code => country_name mapping

        if (!empty($countryCodesInReport)) {
            try {
                // Fetch ALL countries and then filter in memory for simplicity.
                $response = Http::get('https://restcountries.com/v3.1/all?fields=name,idd');

                if ($response->successful()) {
                    $apiCountries = $response->json();
                    foreach ($apiCountries as $country) {
                        $commonName = $country['name']['common'] ?? 'Unknown Country';
                        $root = $country['idd']['root'] ?? '';
                        $suffixes = $country['idd']['suffixes'] ?? [];
                        $callingCode = '';
                        if (!empty($root)) {
                            $callingCode = ltrim($root, '+'); // Remove '+' for comparison
                            if (!empty($suffixes)) {
                                $callingCode .= $suffixes[0];
                            }
                        }
                        // If the calling code exists in our report, map it to its common name
                        if (in_array($callingCode, $countryCodesInReport)) {
                            $countryNames[$callingCode] = $commonName;
                        }
                    }
                } else {
                    Log::error('Failed to fetch countries from API for report: ' . $response->status());
                    session()->flash('error', 'Could not load country names for the report. Data might be incomplete.');
                }
            } catch (\Exception $e) {
                Log::error('Error fetching countries for report: ' . $e->getMessage());
                session()->flash('error', 'An error occurred while loading country names for the report.');
            }
        }

        // 3. Combine counts with country names for display.
        $reportData = $contactsByCountryCode->map(function ($item) use ($countryNames) {
            $countryName = $countryNames[$item->country_code] ?? 'Unknown Country';
            return [
                'country_code' => $item->country_code,
                'country_name' => $countryName,
                'total_contacts' => $item->total,
            ];
        });

        return view('reports.contacts_by_country', compact('reportData'));
    }
}

