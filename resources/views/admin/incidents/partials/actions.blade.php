<a href="{{ route('admin.incidents.edit', $incident->id) }}"
   class="inline-flex items-center justify-center w-8 h-8 bg-yellow-500 rounded-lg text-white shadow hover:bg-yellow-600 transition"
   title="Edit Incident">
    <i class="fas fa-edit text-sm"></i>
</a>

<a href="{{ route('admin.human_loss.create', $incident->id) }}"
   class="inline-flex items-center justify-center w-8 h-8 bg-blue-600 rounded-lg text-white shadow hover:bg-blue-700 transition"
   title="Add Human Loss">
    <i class="fas fa-user-injured text-sm"></i>
</a>

<form action="{{ route('admin.incidents.destroy', $incident->id) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit"
            onclick="return confirm('Delete this incident?')"
            class="inline-flex items-center justify-center w-8 h-8 bg-red-600 rounded-lg text-white shadow hover:bg-red-700 transition"
            title="Delete Incident">
        <i class="fas fa-trash text-sm"></i>
    </button>
</form>
