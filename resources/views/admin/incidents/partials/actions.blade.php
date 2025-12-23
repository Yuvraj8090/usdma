<a href="{{ route('admin.incidents.edit', $incident->id) }}"
<<<<<<< HEAD
   class="inline-flex items-center justify-center w-8 h-8 bg-yellow-500 rounded-lg text-white shadow hover:bg-yellow-600 transition"
   title="Edit Incident">
    <i class="fas fa-edit text-sm"></i>
</a>

<a href="{{ route('admin.human_loss.create', $incident->id) }}"
   class="inline-flex items-center justify-center w-8 h-8 bg-blue-600 rounded-lg text-white shadow hover:bg-blue-700 transition"
   title="Add Human Loss">
    <i class="fas fa-user-injured text-sm"></i>
=======
    class="inline-flex items-center px-3 py-1 bg-yellow-500 rounded-lg text-white font-medium shadow hover:bg-yellow-600 transition">
    <i class="fas fa-edit mr-1 text-xs"></i> Edit
</a>

<a href="{{ route('admin.human_loss.create', $incident->id) }}"
    class="inline-flex items-center px-3 py-1 bg-blue-600 rounded-lg text-white font-medium shadow hover:bg-blue-700 transition">
    <i class="fas fa-user-injured mr-1 text-xs"></i> Add Human Loss
>>>>>>> 3cefa76759533a53c98fcf2b1dd4d85033467466
</a>

<form action="{{ route('admin.incidents.destroy', $incident->id) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
<<<<<<< HEAD
    <button type="submit"
            onclick="return confirm('Delete this incident?')"
            class="inline-flex items-center justify-center w-8 h-8 bg-red-600 rounded-lg text-white shadow hover:bg-red-700 transition"
            title="Delete Incident">
        <i class="fas fa-trash text-sm"></i>
=======
    <button onclick="return confirm('Delete this incident?')" type="submit"
        class="inline-flex items-center px-3 py-1 bg-red-600 rounded-lg text-white font-medium shadow hover:bg-red-700 transition">
        <i class="fas fa-trash mr-1 text-xs"></i> Delete
>>>>>>> 3cefa76759533a53c98fcf2b1dd4d85033467466
    </button>
</form>
