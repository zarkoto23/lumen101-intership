<x-app-layout>

    <x-slot name="header">
        Student Dashboard
    </x-slot>


    <div class="p-6">


        <h2 class="text-xl font-bold mb-6">
            My Courses
        </h2>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


            @forelse($enrollments as $enrollment)


                <div class="border rounded p-4">


                    <h3 class="font-bold text-lg">
                        {{ $enrollment->course->title }}
                    </h3>


                    <p>
                        Status:
                        {{ $enrollment->status }}
                    </p>


                    <p>
                        Enrolled:
                        {{ $enrollment->enrolled_at }}
                    </p>


                </div>


            @empty


                <p>
                    You have no enrolled courses.
                </p>


            @endforelse


        </div>


    </div>

</x-app-layout>