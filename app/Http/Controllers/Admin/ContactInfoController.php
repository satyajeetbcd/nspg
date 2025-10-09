<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    public function index()
    {
        $contactInfos = ContactInfo::orderBy('sort_order')->get();
        return view('admin.contact-infos.index', compact('contactInfos'));
    }

    public function show(ContactInfo $contactInfo)
    {
        return view('admin.contact-infos.show', compact('contactInfo'));
    }

    public function create()
    {
        return view('admin.contact-infos.create');
    }

    public function store(Request $request)
    {
        // Implementation for storing contact info
        return redirect()->route('admin.contact-infos.index');
    }

    public function edit(ContactInfo $contactInfo)
    {
        return view('admin.contact-infos.edit', compact('contactInfo'));
    }

    public function update(Request $request, ContactInfo $contactInfo)
    {
        // Implementation for updating contact info
        return redirect()->route('admin.contact-infos.index');
    }

    public function destroy(ContactInfo $contactInfo)
    {
        // Implementation for deleting contact info
        return redirect()->route('admin.contact-infos.index');
    }
}