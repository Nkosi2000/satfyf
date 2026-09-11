<x-admin.layout title="Add FAQ">
    <form method="POST" action="{{ route('admin.faqs.store') }}" class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        @include('admin.faqs._form')

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Save</button>
            <a href="{{ route('admin.faqs.index') }}" class="text-sm text-slate-500 hover:text-slate-900">Cancel</a>
        </div>
    </form>
</x-admin.layout>
