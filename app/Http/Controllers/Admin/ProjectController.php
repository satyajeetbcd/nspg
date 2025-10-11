<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::ordered()->get();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projectTypes = Project::getProjectTypes();
        return view('admin.projects.create', compact('projectTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_type' => 'required|in:residential,commercial,industrial',
            'location' => 'required|string|max:255',
            'capacity' => 'nullable|string|max:100',
            'image' => 'required|image|max:51200', // 50MB in KB
            'image_alt' => 'nullable|string|max:255',
            'installation_date' => 'nullable|date',
            'cost' => 'nullable|numeric|min:0',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Additional file size check
            if ($image->getSize() > 52428800) { // 50MB in bytes
                return back()->withErrors(['image' => 'File size exceeds the maximum allowed limit of 50MB.'])->withInput();
            }
            
            // Create projects directory in public if it doesn't exist
            $projectsDir = public_path('images/projects');
            if (!file_exists($projectsDir)) {
                mkdir($projectsDir, 0755, true);
            }
            
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/projects/' . $imageName;
            
            // Move image to public directory
            $image->move($projectsDir, $imageName);
            
            $data['image_path'] = $imagePath;
        }

        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $request->sort_order ?? Project::max('sort_order') + 1;

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $projectTypes = Project::getProjectTypes();
        return view('admin.projects.edit', compact('project', 'projectTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_type' => 'required|in:residential,commercial,industrial',
            'location' => 'required|string|max:255',
            'capacity' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:51200', // 50MB in KB
            'image_alt' => 'nullable|string|max:255',
            'installation_date' => 'nullable|date',
            'cost' => 'nullable|numeric|min:0',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->all();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Additional file size check
            if ($image->getSize() > 52428800) { // 50MB in bytes
                return back()->withErrors(['image' => 'File size exceeds the maximum allowed limit of 50MB.'])->withInput();
            }
            
            // Delete old image from public directory
            if ($project->image_path && file_exists(public_path($project->image_path))) {
                unlink(public_path($project->image_path));
            }
            
            // Create projects directory in public if it doesn't exist
            $projectsDir = public_path('images/projects');
            if (!file_exists($projectsDir)) {
                mkdir($projectsDir, 0755, true);
            }
            
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/projects/' . $imageName;
            
            // Move image to public directory
            $image->move($projectsDir, $imageName);
            
            $data['image_path'] = $imagePath;
        }

        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Delete image file from public directory
        if ($project->image_path && file_exists(public_path($project->image_path))) {
            unlink(public_path($project->image_path));
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    /**
     * Toggle project status
     */
    public function toggleStatus(Project $project)
    {
        $project->update(['is_active' => !$project->is_active]);
        
        return response()->json([
            'success' => true,
            'is_active' => $project->is_active,
            'message' => 'Project status updated successfully.'
        ]);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Project $project)
    {
        $project->update(['is_featured' => !$project->is_featured]);
        
        return response()->json([
            'success' => true,
            'is_featured' => $project->is_featured,
            'message' => 'Project featured status updated successfully.'
        ]);
    }

    /**
     * Reorder projects
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'projects' => 'required|array',
            'projects.*.id' => 'required|exists:projects,id',
            'projects.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->projects as $projectData) {
            Project::where('id', $projectData['id'])
                ->update(['sort_order' => $projectData['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Project order updated successfully.'
        ]);
    }
}
