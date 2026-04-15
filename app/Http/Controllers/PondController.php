<?php

namespace App\Http\Controllers;

use App\Models\Pond;
use Illuminate\Http\Request;

class PondController extends Controller
{
    public function index()
    {
        $ponds = Pond::withCount('feedLogs')
            ->withSum('feedLogs', 'quantity_kg')
            ->withSum('feedLogs', 'total_cost')
            ->latest()
            ->get()
            ->each(function ($pond) {
                $pond->total_kg = ($pond->feed_logs_sum_quantity_kg ?? 0) * 15;
            });

        return view('ponds.index', compact('ponds'));
    }

    public function create()
    {
        return view('ponds.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:ponds,name',
            'species'     => 'nullable|string|max:255',
            'stock_count' => 'required|integer|min:1',
            'stocked_at'  => 'nullable|date',
            'notes'       => 'nullable|string',
        ]);

        Pond::create($validated);

        return redirect()->route('ponds.index')
            ->with('success', "Pond '{$validated['name']}' created successfully.");
    }

    public function show(Pond $pond)
    {
        $logs = $pond->feedLogs()
            ->with('feedSize')
            ->latest('log_date')
            ->paginate(20);

        $stats = [
            'total_feed_kg'   => $pond->feedLogs()->sum('quantity_kg'),
            'total_feed_bags' => $pond->feedLogs()->sum('quantity_kg') / 1,
            'total_cost'      => $pond->feedLogs()->sum('total_cost'),
            'today_feed_kg'   => $pond->feedLogs()->whereDate('log_date', today())->sum('quantity_kg'),
            'today_cost'      => $pond->feedLogs()->whereDate('log_date', today())->sum('total_cost'),
            'this_month_kg'   => $pond->feedLogs()->whereMonth('log_date', now()->month)->sum('quantity_kg'),
            'this_month_cost' => $pond->feedLogs()->whereMonth('log_date', now()->month)->sum('total_cost'),
            'log_days'        => $pond->feedLogs()->distinct('log_date')->count('log_date'),
        ];

        return view('ponds.show', compact('pond', 'logs', 'stats'));
    }

    public function edit(Pond $pond)
    {
        return view('ponds.edit', compact('pond'));
    }

    public function update(Request $request, Pond $pond)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:ponds,name,' . $pond->id,
            'species'     => 'nullable|string|max:255',
            'stock_count' => 'required|integer|min:1',
            'stocked_at'  => 'nullable|date',
            'notes'       => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $pond->update($validated);

        return redirect()->route('ponds.index')
            ->with('success', "Pond '{$pond->name}' updated successfully.");
    }

    public function destroy(Pond $pond)
    {
        $name = $pond->name;
        $pond->delete();

        return redirect()->route('ponds.index')
            ->with('success', "Pond '{$name}' deleted.");
    }
}