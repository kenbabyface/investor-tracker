<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function index()
    {
        $investors = Investor::latest()->paginate(10);
        return view('investors.index', compact('investors'));
    }

    public function create()
    {
        return view('investors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:investors',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'investment_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,active,inactive',
            'notes' => 'nullable|string',
        ]);

        Investor::create($validated);
        return redirect()->route('investors.index')->with('success', 'Investor added successfully!');
    }

    public function show(Investor $investor)
    {
        return view('investors.show', compact('investor'));
    }

    public function edit(Investor $investor)
    {
        return view('investors.edit', compact('investor'));
    }

    public function update(Request $request, Investor $investor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:investors,email,' . $investor->id,
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'investment_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,active,inactive',
            'notes' => 'nullable|string',
        ]);

        $investor->update($validated);
        return redirect()->route('investors.index')->with('success', 'Investor updated successfully!');
    }

    public function destroy(Investor $investor)
    {
        $investor->delete();
        return redirect()->route('investors.index')->with('success', 'Investor deleted successfully!');
    }
}