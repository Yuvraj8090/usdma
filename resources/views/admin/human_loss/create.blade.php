<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            {{-- Title --}}
            <div class="flex items-center space-x-3">
                <i class="fas fa-user-injured text-red-600 text-xl"></i>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                    Add Human Loss (Incident #{{ $incidentId }})
                </h2>
            </div>

            {{-- Back Button --}}
            
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 lg:px-8">

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div
                class="mb-4 p-4 bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR MESSAGE --}}
        @if (session('error'))
            <div
                class="mb-4 p-4 bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-100 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())
            <div
                class="mb-4 p-4 bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-100 rounded">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- CREATE FORM CARD --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700">

            {{-- Card Header --}}
            <div class="px-6 py-4 bg-gray-700 rounded-t-xl flex items-center space-x-4">
    
    {{-- Back Button --}}
    <a href="{{ route('admin.incidents.index') }}"
       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded hover:bg-gray-700 transition">
        <i class="fas fa-arrow-left mr-2"></i>
        Back
    </a>

    {{-- Title --}}
    <h3 class="text-lg font-medium text-white flex items-center">
        <i class="fas fa-user-injured mr-2"></i>
        Human Loss Details
    </h3>

</div>


            {{-- Form --}}
            <div class="p-6">
                @include('admin.human_loss.partials.form')
            </div>
        </div>

        {{-- Existing Records Table --}}
        @include('admin.human_loss.partials.table')

    </div>

</x-app-layout>
