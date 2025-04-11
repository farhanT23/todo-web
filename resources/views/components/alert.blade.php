<div class="flex items-center p-4 mb-4 text-sm 

@if ($type == 'success') text-green-800  border-green-300 bg-green-50
@elseif($type == 'info')
    text-blue-800 border-blue-300 bg-blue-50
@elseif($type == 'warning')
    text-yellow-800 border-yellow-300 bg-yellow-50
@elseif($type == 'error')
text-red-800 border border-red-300 bg-red-50 @endif
rounded-lg "
    role="alert">
    <div>
        {{ $slot }}
    </div>
</div>
