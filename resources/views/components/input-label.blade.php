@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {{ $attributes->get('label') ?? $value ?? $slot }}>
    {{ $value ?? $slot }}
</label>
