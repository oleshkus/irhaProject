<!-- resources/views/components/table.blade.php -->
<table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200']) }}>
    {{ $slot }}
</table>
