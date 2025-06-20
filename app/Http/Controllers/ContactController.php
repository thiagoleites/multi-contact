<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Show the form for creating a new contact for a specific person.
     */
    public function create(Person $person)
    {
        // Fetch countries and calling codes from the external API
        $countries = [];
        try {
            // Filter fields to only get 'name.common' and 'idd' (international direct dialing) which contains calling codes.
            $response = Http::get('https://restcountries.com/v3.1/all?fields=name,idd');

            if ($response->successful()) {
                $apiCountries = $response->json();
                foreach ($apiCountries as $country) {
                    $commonName = $country['name']['common'] ?? 'Unknown Country';
                    $root = $country['idd']['root'] ?? '';
                    $suffixes = $country['idd']['suffixes'] ?? [];

                    // Construct the full calling code. Some countries have multiple suffixes,
                    $callingCode = '';
                    if (!empty($root)) {
                        $callingCode = $root;
                        if (!empty($suffixes)) {
                            $callingCode .= $suffixes[0]; // Take the first suffix
                        }
                    }

                    if (!empty($callingCode)) {
                        // Store the country name and its calling code.
                        $countries[] = [
                            'value' => ltrim($callingCode, '+'), // Remove '+' for storage if present
                            'text' => $commonName . ' (' . $callingCode . ')',
                        ];
                    }
                }
                // Sort countries alphabetically by their display text
                usort($countries, function($a, $b) {
                    return strcmp($a['text'], $b['text']);
                });
            } else {
                Log::error('Failed to fetch countries from API: ' . $response->status());
                session()->flash('error', 'Could not load country data. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching countries: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while loading country data.');
        }

        return view('contacts.create', compact('person', 'countries'));
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(Request $request, Person $person)
    {
        // Validate the incoming request data.
        $request->validate([
            'country_code' => 'required|string',
            'number' => [
                'required',
                'string',
                'digits:9', // Exactly 9 digits
                'numeric',  // Ensure it's numeric
                Rule::unique('contacts')->where(function ($query) use ($request) {
                    return $query->where('country_code', $request->country_code)
                        ->where('number', $request->number)
                        ->whereNull('deleted_at'); // Only consider non-soft-deleted records
                }),
            ],
        ], [
            'number.digits' => 'The number must be exactly 9 digits.',
            'number.numeric' => 'The number must contain only digits.',
            'number.unique' => 'This contact (country code + number) already exists in the system.',
        ]);

        // Create a new Contact record for the specific person.
        $contact = $person->contacts()->create([
            'country_code' => $request->country_code,
            'number' => $request->number,
        ]);

        return redirect()->route('people.show', $person->id)
            ->with('success', 'Contact added successfully!');
    }

    /**
     * Show the form for editing the specified contact.
     */
    public function edit(Person $person, Contact $contact)
    {
        // Ensure the contact belongs to the person.
        if ($contact->person_id !== $person->id) {
            abort(404); // Or redirect with an error
        }

        // Fetch countries and calling codes from the external API (same logic as create)
        $countries = [];
        try {
            $response = Http::get('https://restcountries.com/v3.1/all?fields=name,idd');
            if ($response->successful()) {
                $apiCountries = $response->json();
                foreach ($apiCountries as $country) {
                    $commonName = $country['name']['common'] ?? 'Unknown Country';
                    $root = $country['idd']['root'] ?? '';
                    $suffixes = $country['idd']['suffixes'] ?? [];
                    $callingCode = '';
                    if (!empty($root)) {
                        $callingCode = $root;
                        if (!empty($suffixes)) {
                            $callingCode .= $suffixes[0];
                        }
                    }
                    if (!empty($callingCode)) {
                        $countries[] = [
                            'value' => ltrim($callingCode, '+'),
                            'text' => $commonName . ' (' . $callingCode . ')',
                        ];
                    }
                }
                usort($countries, function($a, $b) {
                    return strcmp($a['text'], $b['text']);
                });
            } else {
                Log::error('Failed to fetch countries from API: ' . $response->status());
                session()->flash('error', 'Could not load country data. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching countries: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while loading country data.');
        }

        return view('contacts.edit', compact('person', 'contact', 'countries'));
    }

    /**
     * Update the specified contact in storage.
     */
    public function update(Request $request, Person $person, Contact $contact)
    {
        // Ensure the contact belongs to the person.
        if ($contact->person_id !== $person->id) {
            abort(404); // Or redirect with an error
        }

        // Validate the incoming request data.
        $request->validate([
            'country_code' => 'required|string',
            'number' => [
                'required',
                'string',
                'digits:9',
                'numeric',
                Rule::unique('contacts')->ignore($contact->id)->where(function ($query) use ($request) {
                    return $query->where('country_code', $request->country_code)
                        ->where('number', $request->number)
                        ->whereNull('deleted_at'); // Only consider non-soft-deleted records
                }),
            ],
        ], [
            'number.digits' => 'The number must be exactly 9 digits.',
            'number.numeric' => 'The number must contain only digits.',
            'number.unique' => 'This contact (country code + number) already exists in the system.',
        ]);

        // Update the contact's details.
        $contact->update($request->only(['country_code', 'number']));

        return redirect()->route('people.show', $person->id)
            ->with('success', 'Contact updated successfully!');
    }

    /**
     * Remove the specified contact from storage (soft delete).
     */
    public function destroy(Person $person, Contact $contact)
    {
        // Ensure the contact belongs to the person.
        if ($contact->person_id !== $person->id) {
            return redirect()->back()->with('error', 'Invalid contact for this person.');
        }

        try {
            $contact->delete(); // Soft delete the contact
            return redirect()->route('people.show', $person->id)
                ->with('success', 'Contact soft-deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error soft-deleting contact: ' . $e->getMessage());
            return redirect()->route('people.show', $person->id)
                ->with('error', 'Error soft-deleting contact: ' . $e->getMessage());
        }
    }
}

