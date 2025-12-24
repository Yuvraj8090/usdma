<div class="flex items-center justify-center gap-2">
    <button
        class="editActivity px-2 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700"
        data-id="{{ $row->id }}">
        <i class="fas fa-edit"></i>
    </button>

    <button
        class="deleteActivity px-2 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700"
        data-id="{{ $row->id }}">
        <i class="fas fa-trash"></i>
    </button>
</div>
