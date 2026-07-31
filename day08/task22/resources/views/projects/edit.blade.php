<x-app-layout>

    <x-slot name="header">
        Edit Project
    </x-slot>

    @if ($errors->any())

    <div class="mb-4 bg-red-100 p-4">

        <ul>

            @foreach ($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="POST" action="{{ route('projects.update', $project) }}">

                @csrf
                @method('PUT')

                <div>
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $project->name }}">
                </div>

                <div>
                    <label>Description</label>
                    <textarea name="description">{{ $project->description }}</textarea>
                </div>

                <div>
                    <label>Start date</label>
                    <input type="date" name="start_date" value="{{ $project->start_date }}">
                </div>

                <div>
                    <label>Deadline</label>
                    <input type="date" name="deadline" value="{{ $project->deadline }}">
                </div>

                <div>
                    <label>Status</label>

                    <select name="status">

                        <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                    </select>

                </div>


                <button type="submit">
                    Save
                </button>

            </form>

        </div>
    </div>

</x-app-layout>
