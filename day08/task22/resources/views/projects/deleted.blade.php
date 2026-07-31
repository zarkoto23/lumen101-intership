<x-app-layout>

    <x-slot name="header">
        Deleted Projects
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white p-6 rounded shadow">

                <h2 class="text-xl font-bold">
                    Deleted Projects
                </h2>


                @forelse($projects as $project)
                    <div class="mt-6 border p-4 rounded">

                        <h3 class="font-bold">
                            {{ $project->name }}
                        </h3>


                        <p>
                            Deleted:
                            {{ $project->deleted_at }}
                        </p>


                        <form method="POST" action="{{ route('projects.restore', $project->id) }}" class="mt-4">

                            @csrf
                            @method('PATCH')

                            <button type="submit">
                                Restore
                            </button>

                        </form>

                    </div>

                @empty

                    <p class="mt-4">
                        No deleted projects.
                    </p>
                @endforelse


                <div class="mt-6">

                    {{ $projects->links() }}

                </div>


            </div>


        </div>

    </div>

</x-app-layout>
