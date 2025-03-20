<?php

namespace App\Jobs;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UpdateProjectStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get the current time minus 5 minutes
        $fiveMinutesAgo = Carbon::now()->subMinutes(5);

        $projects = Project::where('updated_at', '<=', $fiveMinutesAgo)->where('status', 'pending')->get();

        foreach ($projects as $project) {
            $project->status = 'completed';
            $project->save();
            Log::info("Updated project ID {$project->id} to completed.");
        }

        Log::info("Job completed: Updated " . $projects->count() . " projects.");
    }

}
