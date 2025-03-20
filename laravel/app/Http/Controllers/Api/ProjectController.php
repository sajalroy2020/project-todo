<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function list()
    {
        if (Auth::user()->role == 'admin') {
            $projects = Project::latest()->paginate(5);
        } else {
            $projects = Project::where('user_id', auth()->id())->paginate(5);
        }

        return response()->json([
            'success' => true,
            'data' => $projects,
        ], 200);
    }

    public function create()
    {
        // For API, we don't need to return a view. Instead, provide any validation or data.
        return response()->json([
            'success' => true,
            'message' => 'Ready to create a new project.',
        ], 200);
    }

    public function store(ProjectRequest $request)
    {
        if ($request->id) {
            $project = Project::find($request->id);
            $msg = 'Updated Successfully';
        } else {
            $project = new Project();
            $msg = 'Created successfully';
        }

        try {
            $project->title = $request->title;
            $project->description = $request->description;
            $project->price = $request->price;
            $project->status = $request->status;

            if (auth()->user()->role !== 'admin') {
                $project->user_id = auth()->id();
            }

            $project->save();

            return response()->json([
                'success' => true,
                'message' => $msg,
                'data' => $project,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $th->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $project,
        ], 200);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully.',
        ], 200);
    }
}
