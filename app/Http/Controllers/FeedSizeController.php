<?php

namespace App\Http\Controllers;

use App\Models\FeedSize;
use Illuminate\Http\Request;

class FeedSizeController extends Controller
{
    public function index()
    {
        $feedSizes = FeedSize::latest()->get();
        return view('feed-sizes.index', compact('feedSizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'size'         => 'nullable|string|max:50',
            'price_per_kg' => 'required|numeric|min:0',
            'description'  => 'nullable|string',
        ]);

        FeedSize::create($validated);

        return redirect()->route('feed-sizes.index')
            ->with('success', "Feed type '{$validated['name']}' added successfully.");
    }

    public function update(Request $request, FeedSize $feedSize)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'size'         => 'nullable|string|max:50',
            'price_per_kg' => 'required|numeric|min:0',
            'description'  => 'nullable|string',
            'is_active'    => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $feedSize->update($validated);

        return redirect()->route('feed-sizes.index')
            ->with('success', "Feed type updated.");
    }

    public function destroy(FeedSize $feedSize)
    {
        $feedSize->delete();
        return redirect()->route('feed-sizes.index')
            ->with('success', 'Feed type deleted.');
    }

    // API endpoint — returns price for a given feed size (used by JS)
    public function getPrice(FeedSize $feedSize)
    {
        return response()->json([
            'price_per_kg' => $feedSize->price_per_kg,
            'name'         => $feedSize->name,
        ]);
    }
}