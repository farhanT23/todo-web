<div class="mb-5">
    @if (isset($label))
        <label for="{{ $name }}" class="block mb-2 text-sm font-medium text-gray-900 ">{{ $label }}</label>
    @endif
    <input :type="$type" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5']) }}
        :class="{
            'border-red-500': $errors - > has($name),
            'border-gray-300': !$errors - > has($name)
        }"
        :name="$name" :value="old($name)" :placeholder="$placeholder" :required="$required" />
    @error($name)
        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>
