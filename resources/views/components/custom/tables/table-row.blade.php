<!-- resources/views/components/table-row.blade.php -->
<tr {{ $attributes->merge(['class' => 'bg-white']) }}>
    {{ $slot }}
</tr>
