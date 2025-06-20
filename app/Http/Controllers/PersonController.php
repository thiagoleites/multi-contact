<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource (people).
     */
    public function index()
    {
        // Retrieve all non-soft-deleted people and order them by name.
        $people = Person::orderBy('name')->get();
        return view('people.index', compact('people'));
    }

    /**
     * Show the form for creating a new person.
     */
    public function create()
    {
        return view('people.create');
    }

    /**
     * Store a newly created person in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|min:5',
            'email' => [
                'required',
                'email',
                Rule::unique('people')->where(function ($query) {
                    return $query->whereNull('deleted_at'); // Only consider non-soft-deleted records
                }),
            ],
        ]);

        // Generate a random avatar URL from the PixelEncounter API.
        $avatarUrl = null;
        try {
            // The API provides a random monster image.
            $response = Http::get('https://app.pixelencounter.com/api/basic/monsters/random');
            if ($response->successful()) {
                $avatarUrl = $response->effectiveUri()->__toString(); // Get the final URL after redirects
            } else {
                Log::warning('Failed to fetch avatar from PixelEncounter API: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Error fetching avatar: ' . $e->getMessage());
        }

        // Create a new Person record in the database.
        $person = Person::create([
            'name' => $request->name,
            'email' => $request->email,
            'avatar_url' => $avatarUrl, // Store the generated avatar URL
        ]);

        // Redirect to the person's details page with a success message.
        return redirect()->route('people.show', $person->id)
            ->with('success', 'Person created successfully!');
    }

    /**
     * Display the specified person's details.
     */
    public function show(Person $person)
    {
        // Load the person's contacts, ordered by country code and number.
        $person->load(['contacts' => function ($query) {
            $query->orderBy('country_code')->orderBy('number');
        }]);

        return view('people.show', compact('person'));
    }

    /**
     * Show the form for editing the specified person.
     */
    public function edit(Person $person)
    {
        return view('people.edit', compact('person'));
    }

    /**
     * Update the specified person in storage.
     */
    public function update(Request $request, Person $person)
    {
        // Validate the incoming request data.
        $request->validate([
            'name' => 'required|string|min:5',
            'email' => [
                'required',
                'email',
                Rule::unique('people')->ignore($person->id)->where(function ($query) {
                    return $query->whereNull('deleted_at'); // Only consider non-soft-deleted records
                }),
            ],
        ]);

        // Update the person's details.
        $person->update($request->only(['name', 'email']));

        // Redirect back to the person's details page with a success message.
        return redirect()->route('people.show', $person->id)
            ->with('success', 'Person updated successfully!');
    }

    /**
     * Remove the specified person from storage (soft delete).
     */
    public function destroy(Person $person)
    {
        try {
            // Soft delete the person.
            $person->delete();

            // Soft delete all associated contacts.
            foreach ($person->contacts()->get() as $contact) {
                $contact->delete();
            }

            return redirect()->route('people.index')
                ->with('success', 'Person and associated contacts soft-deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error soft-deleting person: ' . $e->getMessage());
            return redirect()->route('people.index')
                ->with('error', 'Error soft-deleting person: ' . $e->getMessage());
        }
    }
}

