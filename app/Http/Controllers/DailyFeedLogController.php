<?php

namespace App\Http\Controllers;

use App\Models\DailyFeedLog;
use App\Models\FeedSize;
use App\Models\Pond;
use Illuminate\Http\Request;

class DailyFeedLogController extends Controller
{
    public function index(Request $request)
    {
        $ponds     = Pond::where('is_active', true)->get();
        $feedSizes = FeedSize::where('is_active', true)->get();

        $query = DailyFeedLog::with(['pond', 'feedSize'])->latest('log_date')->latest('id');

        if ($request->filled('pond_id')) {
            $query->where('pond_id', $request->pond_id);
        }
        if ($request->filled('feed_size_id')) {
            $query->where('feed_size_id', $request->feed_size_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('log_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('log_date', '<=', $request->date_to);
        }

        $logs = $query->paginate(25)->withQueryString();

        // Summary stats for filtered result
        $summary = DailyFeedLog::query();
        if ($request->filled('pond_id'))      $summary->where('pond_id', $request->pond_id);
        if ($request->filled('feed_size_id')) $summary->where('feed_size_id', $request->feed_size_id);
        if ($request->filled('date_from'))    $summary->whereDate('log_date', '>=', $request->date_from);
        if ($request->filled('date_to'))      $summary->whereDate('log_date', '<=', $request->date_to);

        $summaryData = [
            'total_kg'   => $summary->sum('quantity_kg')*15,
            'total_cost' => $summary->sum('total_cost'),
        ];

        return view('feed-logs.index', compact('logs', 'ponds', 'feedSizes', 'summaryData'));
    }

    public function create()
    {
        $ponds     = Pond::where('is_active', true)->orderBy('name')->get();
        $feedSizes = FeedSize::where('is_active', true)->orderBy('name')->get();

        return view('feed-logs.create', compact('ponds', 'feedSizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pond_id'      => 'required|exists:ponds,id',
            'feed_size_id' => 'required|exists:feed_sizes,id',
            'log_date'     => 'required|date|before_or_equal:today',
            'quantity_kg'  => 'required|numeric|min:1',
            'notes'        => 'nullable|string',
        ]);

        $feedSize = FeedSize::findOrFail($validated['feed_size_id']);

        DailyFeedLog::create([
            'pond_id'      => $validated['pond_id'],
            'feed_size_id' => $validated['feed_size_id'],
            'log_date'     => $validated['log_date'],
            'quantity_kg'     => $validated['quantity_kg'],
            'price_per_kg' => $feedSize->price_per_kg,
            'total_cost'   => round($validated['quantity_kg'] * $feedSize->price_per_kg, 2),
            'notes'        => $validated['notes'] ?? null,
        ]);

        return redirect()->route('feed-logs.index')
            ->with('success', 'Feed log recorded successfully.');
    }

    public function edit(DailyFeedLog $feedLog)
    {
        $ponds     = Pond::where('is_active', true)->orderBy('name')->get();
        $feedSizes = FeedSize::where('is_active', true)->orderBy('name')->get();

        return view('feed-logs.edit', compact('feedLog', 'ponds', 'feedSizes'));
    }

    public function update(Request $request, DailyFeedLog $feedLog)
    {
        $validated = $request->validate([
            'pond_id'      => 'required|exists:ponds,id',
            'feed_size_id' => 'required|exists:feed_sizes,id',
            'log_date'     => 'required|date|before_or_equal:today',
            'quantity_kg'  => 'required|numeric|min:0.01',
            'notes'        => 'nullable|string',
        ]);

        $feedSize = FeedSize::findOrFail($validated['feed_size_id']);

        $feedLog->update([
            'pond_id'      => $validated['pond_id'],
            'feed_size_id' => $validated['feed_size_id'],
            'log_date'     => $validated['log_date'],
            'quantity_kg'  => $validated['quantity_kg'],
            'price_per_kg' => $feedSize->price_per_kg,
            'total_cost'   => round($validated['quantity_kg'] * $feedSize->price_per_kg, 2),
            'notes'        => $validated['notes'] ?? null,
        ]);

        return redirect()->route('feed-logs.index')
            ->with('success', 'Feed log updated.');
    }

    public function destroy(DailyFeedLog $feedLog)
    {
        $feedLog->delete();
        return redirect()->route('feed-logs.index')
            ->with('success', 'Feed log deleted.');
    }

    // Overview dashboard for all ponds
    public function overview()
    {
        $ponds = Pond::where('is_active', true)
            ->with(['feedLogs' => function ($q) {
                $q->whereDate('log_date', today());
            }, 'feedLogs.feedSize'])
            ->get();

        $overallStats = [
            'total_kg_today'      => DailyFeedLog::whereDate('log_date', today())->sum('quantity_kg'),
            'total_cost_today'    => DailyFeedLog::whereDate('log_date', today())->sum('total_cost'),
            'total_kg_month'      => DailyFeedLog::whereMonth('log_date', now()->month)->sum('quantity_kg'),
            'total_cost_month'    => DailyFeedLog::whereMonth('log_date', now()->month)->sum('total_cost'),
            'total_kg_alltime'    => DailyFeedLog::sum('quantity_kg'),
            'total_cost_alltime'  => DailyFeedLog::sum('total_cost'),
        ];

        // Last 7 days per pond (for mini chart data)
        $last7Days = collect(range(6, 0))->map(fn($d) => now()->subDays($d)->toDateString());

        return view('feed-logs.overview', compact('ponds', 'overallStats', 'last7Days'));
    }
}