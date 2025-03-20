<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function list()
    {
        if (Auth::user()->role == 'admin') {
            $data['projects'] = Project::latest()->paginate(5);
        }else{
            $data['projects'] = Project::where('user_id', auth()->id())->paginate(5);
        }

        return view('project.list', $data);
    }

    public function create()
    {
        if (auth()->user()->role == 'admin') {
            Auth::logout();
            return redirect('/login');
        }
        return view('project.create');
    }

    public function store(ProjectRequest $request)
    {
        if ($request->id) {
            $data = Project::find($request->id);
            $msg = 'Updated Successfully';
        }else{
            $data = new Project();
            $msg = 'created successfully';
        }

        try {
            $data->title = $request->title;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->status = $request->status;
            if (auth()->user()->role !== 'admin') {
                $data->user_id = auth()->id();
            }
            $data->save();

            return redirect()->route('project.list')->with('success', $msg);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        $data['project'] = Project::findOrFail($id);
        return view('project.edit', $data);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect()->route('project.list')->with('success', 'Project deleted successfully.');
    }


}
