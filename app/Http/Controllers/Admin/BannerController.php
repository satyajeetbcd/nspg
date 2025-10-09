<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:51200', // 50MB in KB
            'image_alt' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->all();
        
        // Check if file upload failed due to size limits
        if (!$request->hasFile('image') && $request->file('image') === null) {
            return back()->withErrors(['image' => 'File upload failed. Please check if the file size is within the allowed limit (50MB) and try again.'])->withInput();
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Additional file size check
            if ($image->getSize() > 52428800) { // 50MB in bytes
                return back()->withErrors(['image' => 'File size exceeds the maximum allowed limit of 50MB.'])->withInput();
            }
            
            // Create banners directory in public if it doesn't exist
            $bannersDir = public_path('images/banners');
            if (!file_exists($bannersDir)) {
                mkdir($bannersDir, 0755, true);
            }
            
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/banners/' . $imageName;
            
            // Move image to public directory
            $image->move($bannersDir, $imageName);
            
            $data['image_path'] = $imagePath;
        }

        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $request->sort_order ?? Banner::max('sort_order') + 1;

        Banner::create($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created successfully.');
    }

    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:51200', // 50MB in KB
            'image_alt' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->all();
       // dd($request->hasFile('image'));
        // Debug information
        \Log::info('Upload Debug Info:', [
            'hasFile' => $request->hasFile('image'),
            'file' => $request->file('image'),
            'all_files' => $request->allFiles(),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'memory_limit' => ini_get('memory_limit')
        ]);
        
        // Check if file upload failed due to size limits
        if ($request->has('image') && !$request->hasFile('image') && $request->file('image') === null) {
            return back()->withErrors(['image' => 'File upload failed. Please check if the file size is within the allowed limit (50MB) and try again.'])->withInput();
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Additional file size check
            if ($image->getSize() > 52428800) { // 50MB in bytes
                return back()->withErrors(['image' => 'File size exceeds the maximum allowed limit of 50MB.'])->withInput();
            }
            
            // Delete old image from public directory
            if ($banner->image_path && file_exists(public_path($banner->image_path))) {
                unlink(public_path($banner->image_path));
            }
            
            // Create banners directory in public if it doesn't exist
            $bannersDir = public_path('images/banners');
            if (!file_exists($bannersDir)) {
                mkdir($bannersDir, 0755, true);
            }
            
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/banners/' . $imageName;
            
            // Move image to public directory
            $image->move($bannersDir, $imageName);
            
            $data['image_path'] = $imagePath;
        }

        $data['is_active'] = $request->has('is_active');

        $banner->update($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        // Delete image file from public directory
        if ($banner->image_path && file_exists(public_path($banner->image_path))) {
            unlink(public_path($banner->image_path));
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }

    public function toggleStatus(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);
        
        return response()->json([
            'success' => true,
            'is_active' => $banner->is_active,
            'message' => 'Banner status updated successfully.'
        ]);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'banners' => 'required|array',
            'banners.*.id' => 'required|exists:banners,id',
            'banners.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->banners as $bannerData) {
            Banner::where('id', $bannerData['id'])
                ->update(['sort_order' => $bannerData['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Banner order updated successfully.'
        ]);
    }
}
