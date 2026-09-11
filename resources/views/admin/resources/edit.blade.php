<x-admin.layout title="Edit resource">
    <form method="POST" action="{{ route('admin.resources.update', $resource) }}" enctype="multipart/form-data" class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        @method('PUT')
        @include('admin.resources._form')

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Save changes</button>
            <a href="{{ route('admin.resources.index') }}" class="text-sm text-slate-500 hover:text-slate-900">Cancel</a>
        </div>
    </form>
</x-admin.layout>
