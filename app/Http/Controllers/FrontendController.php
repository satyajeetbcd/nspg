<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\SolarSystem;
use App\Models\PageContent;
use App\Models\ContactInfo;
use App\Models\Review;
use App\Models\CalculatorSetting;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->ordered()->get();
        $solarSystems = SolarSystem::active()->ordered()->get();
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        $reviews = Review::active()->featured()->orderBy('created_at', 'desc')->take(6)->get();
        $calculatorSettings = CalculatorSetting::getAllSettings();
        
        return view('frontend.home', compact('banners', 'solarSystems', 'pageContents', 'contactInfos', 'reviews', 'calculatorSettings'));
    }

    public function about()
    {
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        
        return view('frontend.about', compact('pageContents', 'contactInfos'));
    }

    public function services()
    {
        $solarSystems = SolarSystem::active()->ordered()->get();
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        
        return view('frontend.services', compact('solarSystems', 'pageContents', 'contactInfos'));
    }

    public function boardOfDirectors()
    {
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        
        return view('frontend.board-of-directors', compact('pageContents', 'contactInfos'));
    }

    public function businessAndPartnership()
    {
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        
        return view('frontend.business-and-partnership', compact('pageContents', 'contactInfos'));
    }

    public function ourClients()
    {
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        $reviews = Review::active()->featured()->orderBy('created_at', 'desc')->take(6)->get();
        
        return view('frontend.our-clients', compact('pageContents', 'contactInfos', 'reviews'));
    }

    public function download()
    {
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        
        return view('frontend.download', compact('pageContents', 'contactInfos'));
    }

    public function contact()
    {
        $pageContents = PageContent::active()->get()->keyBy('page_key');
        $contactInfos = ContactInfo::active()->ordered()->get();
        
        return view('frontend.contact', compact('pageContents', 'contactInfos'));
    }

    public function submitContactForm(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'system_capacity' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'services' => 'nullable|array',
            'services.*' => 'string|in:Installation,Maintenance,Replacement,Other',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please fill in all required fields correctly.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Prepare contact data
            $contactData = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'system_capacity' => $request->system_capacity,
                'address' => $request->address,
                'services' => $request->services ?? [],
                'message' => $request->message,
            ];

            // Send email
            Mail::to(config('mail.from.address'))->send(new ContactFormMail($contactData));

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully! We will contact you soon.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Contact form submission failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error sending your message. Please try again later.'
            ], 500);
        }
    }
}
