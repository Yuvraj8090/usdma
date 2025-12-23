<a href="{{ route('admin.incidents.edit', $incident->id) }}"
    class="inline-flex items-center px-3 py-1 bg-yellow-500 rounded-lg text-white font-medium shadow hover:bg-yellow-600 transition">
    <i class="fas fa-edit mr-1 text-xs"></i> Edit
</a>

<a href="{{ route('admin.human_loss.create', $incident->id) }}"
    class="inline-flex items-center px-3 py-1 bg-blue-600 rounded-lg text-white font-medium shadow hover:bg-blue-700 transition">
    <i class="fas fa-user-injured mr-1 text-xs"></i> Add Human Loss
</a>

<form action="{{ route('admin.incidents.destroy', $incident->id) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button onclick="return confirm('Delete this incident?')" type="submit"
        class="inline-flex items-center px-3 py-1 bg-red-600 rounded-lg text-white font-medium shadow hover:bg-red-700 transition">
        <i class="fas fa-trash mr-1 text-xs"></i> Delete
    </button>
</form>
