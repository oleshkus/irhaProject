<!-- resources/views/components/select.blade.php -->
<select {{ $attributes->merge(['class' => 'w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50']) }}>
    {{ $slot }}
</select>
