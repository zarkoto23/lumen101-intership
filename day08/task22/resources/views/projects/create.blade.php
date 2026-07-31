<x-app-layout>

    <x-slot name="header">
        Create Project
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="POST" action="{{ route('projects.store') }}">
                @csrf

                <div>
                    <label>Name</label>
                    <input type="text" name="name">
                </div>

                <div>
                    <label>Description</label>
                    <textarea name="description"></textarea>
                </div>

                <div>
                    <label>Start date</label>
                    <input type="date" name="start_date">
                </div>

                <div>
                    <label>Deadline</label>
                    <input type="date" name="deadline">
                </div>

                <div>
                    <label>Status</label>
                    <select name="status">
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <button type="submit">
                    Create
                </button>

            </form>

        </div>
    </div>

</x-app-layout>