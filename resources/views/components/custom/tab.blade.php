<!-- resources/views/components/tab.blade.php -->
<div x-data="{ activeTab: 0 }">
    <div class="flex">
        {{ $tabs }}
    </div>
    <div>
        {{ $content }}
    </div>
</div>
