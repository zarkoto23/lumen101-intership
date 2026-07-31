<x-app-layout>

    <x-slot name="header">
        Create Task
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 sm:px-8">


            <form method="POST" action="{{ route('tasks.store') }}">

                @csrf


                <div>
                    <label>Project</label>

                    <select name="project_id" id="project_id">

                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" data-users='@json($project->users)'>
                                {{ $project->name }}
                            </option>
                        @endforeach

                    </select>

                </div>


                <div>
                    <label>Title</label>

                    <input type="text" name="title">
                </div>


                <div>
                    <label>Description</label>

                    <textarea name="description"></textarea>
                </div>


                <div>
                    <label>Assigned user</label>

                    <select name="assigned_to" id="assigned_to">

                    </select>

                </div>


                <div>
                    <label>Priority</label>

                    <select name="priority">

                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>

                    </select>

                </div>


                <div>
                    <label>Status</label>

                    <select name="status">

                        <option value="new">New</option>
                        <option value="in_progress">In progress</option>
                        <option value="review">Review</option>
                        <option value="completed">Completed</option>

                    </select>

                </div>


                <div>
                    <label>Deadline</label>

                    <input type="date" name="deadline">

                </div>


                <button type="submit">
                    Create
                </button>


            </form>


        </div>

    </div>




    <script>
        const projectSelect = document.getElementById('project_id');
        const userSelect = document.getElementById('assigned_to');


        function loadUsers(projectId) {

            fetch('/projects/' + projectId + '/users')
                .then(response => response.json())
                .then(users => {

                    userSelect.innerHTML = '';


                    users.forEach(user => {

                        const option = document.createElement('option');

                        option.value = user.id;
                        option.textContent = user.name;

                        userSelect.appendChild(option);

                    });

                });

        }


        projectSelect.addEventListener('change', function() {

            loadUsers(this.value);

        });


        loadUsers(projectSelect.value);
    </script>


</x-app-layout>
