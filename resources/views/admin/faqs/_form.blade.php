@php($faq = $faq ?? null)

<x-admin.translatable-field name="question" label="Question" :translations="$faq?->translations('question') ?? []" />
<x-admin.translatable-field name="answer" label="Answer" type="textarea" :translations="$faq?->translations('answer') ?? []" class="mt-5" />

<div class="mt-5 grid gap-5 sm:grid-cols-2">
    <x-admin.field name="order" label="Order" type="number" :value="$faq?->order ?? 0" />
    <x-admin.field name="published" label="Published" type="checkbox" :value="$faq?->published ?? true" />
</div>
