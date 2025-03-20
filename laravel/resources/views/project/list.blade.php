
<x-guest-layout>

    <div class="container">

        @if (auth()->check() && auth()->user()->role !== 'admin')
            <a href="{{ route('project.create') }}" class="btn btn-primary">Add Project</a>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>{{ Str::limit($project->description, 50) }}</td>
                        <td>${{ number_format($project->price, 2) }}</td>
                        <td>{{ ucfirst($project->status) }}</td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('project.edit', $project->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('project.destroy', $project->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $projects->links() }}
    </div>
</x-guest-layout>

