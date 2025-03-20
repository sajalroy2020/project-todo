<x-guest-layout>
    <div class="container">
        <h2>Edit Project</h2>
        <form action="{{ route('project.store') }}" method="POST">
            @csrf
            <input value="{{  $project->id }}" name="id" type="hidden" />
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $project->title }}" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" required>{{ $project->description }}</textarea>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ $project->price }}" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending" {{ $project->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success mt-3">Update</button>
        </form>
    </div>
</x-guest-layout>
