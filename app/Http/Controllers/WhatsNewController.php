<?php

namespace App\Http\Controllers;

use App\Models\WhatsNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WhatsNewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $whatsNew = WhatsNew::ordered()->paginate(10);
        return view('admin.whats-new.index', compact('whatsNew'));
    }

    /**
     * Display frontend listing of the resource.
     */
    public function frontend()
    {
        $whatsNew = WhatsNew::active()->ordered()->get();
        return view('frontend.whats-new', compact('whatsNew'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.whats-new.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'hindi_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'publish_date' => 'required|date',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('whats-new', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        WhatsNew::create($data);

        return redirect()->route('whats-new.index')->with('success', 'What\'s New item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WhatsNew $whatsNew)
    {
        return view('admin.whats-new.show', compact('whatsNew'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WhatsNew $whatsNew)
    {
        return view('admin.whats-new.edit', compact('whatsNew'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WhatsNew $whatsNew)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'hindi_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'publish_date' => 'required|date',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($whatsNew->image) {
                Storage::disk('public')->delete($whatsNew->image);
            }
            $data['image'] = $request->file('image')->store('whats-new', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $whatsNew->update($data);

        return redirect()->route('whats-new.index')->with('success', 'What\'s New item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WhatsNew $whatsNew)
    {
        if ($whatsNew->image) {
            Storage::disk('public')->delete($whatsNew->image);
        }
        
        $whatsNew->delete();

        return redirect()->route('whats-new.index')->with('success', 'What\'s New item deleted successfully.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(WhatsNew $whatsNew)
    {
        $whatsNew->update(['is_active' => !$whatsNew->is_active]);
        
        $status = $whatsNew->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "What's New item {$status} successfully.");
    }
}
