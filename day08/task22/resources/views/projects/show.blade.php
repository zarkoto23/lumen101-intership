<x-app-layout>

    <x-slot name="header">
        {{ $project->name }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <h1 class="text-xl font-bold">
                    {{ $project->name }}
                </h1>

                <p class="mt-4">
                    {{ $project->description }}
                </p>

                <p class="mt-4">
                    Status:
                    {{ $project->status }}
                </p>

                <p>
                    Start:
                    {{ $project->start_date }}
                </p>

                <p>
                    Deadline:
                    {{ $project->deadline }}
                </p>

            </div>


            @can('update', $project)

                <div class="mt-6">

                    <a href="{{ route('projects.edit', $project) }}">
                        Edit Project
                    </a>

                </div>

            @endcan


            @can('delete', $project)

                <div class="mt-6">

                    <form method="POST" action="{{ route('projects.destroy', $project) }}">

                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            Delete Project
                        </button>

                    </form>

                </div>

            @endcan



            <div class="mt-6 bg-white p-6 rounded shadow">

                <h2 class="font-bold">
                    Members
                </h2>


                <ul class="mt-4">

                    @foreach ($project->users as $user)

                        <li>

                            {{ $user->name }}

                            @can('update', $project)

                                @if ($user->id !== $project->owner_id)

                                    <form method="POST"
                                        action="{{ route('projects.users.remove', [$project, $user]) }}"
                                        style="display:inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit">
                                            Remove
                                        </button>

                                    </form>

                                @endif

                            @endcan

                        </li>

                    @endforeach

                </ul>



                @can('update', $project)

                    <form method="POST"
                        action="{{ route('projects.users.add', $project) }}"
                        class="mt-6">

                        @csrf


                        <label>
                            Add user
                        </label>


                        <select name="user_id">

                            @foreach ($users as $user)

                                @if (!$project->users->contains($user->id))

                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>

                                @endif

                            @endforeach

                        </select>



                        <select name="role">

                            <option value="developer">
                                Developer
                            </option>

                            <option value="tester">
                                Tester
                            </option>

                            <option value="manager">
                                Manager
                            </option>

                        </select>



                        <button type="submit">
                            Add
                        </button>


                    </form>

                @endcan


            </div>


        </div>
    </div>

</x-app-layout>