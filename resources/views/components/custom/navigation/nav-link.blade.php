@props(['href', 'active' => false])

<a href="{{ $href }}" 
   {{ $attributes->merge([
       'class' => 'px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out ' . 
                 ($active ? 'bg-white text-blue-800' : 'text-white hover:bg-blue-700')
   ]) }}>
    {{ $slot }}
</a>
