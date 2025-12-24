<div class="flex justify-end gap-2">
    <a href="{{ route('admin.users.edit', $user->id) }}"
       class="inline-flex items-center px-3 py-1.5 rounded-md bg-yellow-500 hover:bg-yellow-600 text-white text-xs shadow">
        <i class="fas fa-edit mr-1"></i> Edit
    </a>

    <form action="{{ route('admin.users.destroy', $user->id) }}"
          method="POST"
          onsubmit="return confirm('Are you sure you want to delete this user?')">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="inline-flex items-center px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs shadow">
            <i class="fas fa-trash mr-1"></i> Delete
        </button>
    </form>
</div>
