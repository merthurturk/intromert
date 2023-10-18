@props(['label'])
<div class="inline-block relative text-left" x-data x-popover>
    <span class="decoration-dashed underline cursor-pointer" x-popover:button>{{ $label }}</span>
    <div class="absolute left-0 inset-y-0" x-popover:panel x-cloak x-transition.origin.top.left>
        <div class="absolute mt-6 top-0 left-0 w-[300px] bg-white p-2 rounded shadow border border-gray-300">
            <h4 class="text-xs uppercase text-gray-500 font-medium tracking-wide m-0 mb-1 p-0">AI Prompt</h4>
            <div class="text-xs text-gray-400 leading-tight">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
