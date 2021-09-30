@php $editing = isset($fileType) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="mime_type"
            label="Mime Type"
            value="{{ old('mime_type', ($editing ? $fileType->mime_type : '')) }}"
            maxlength="255"
            placeholder="Mime Type"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="extensions"
            label="Extensions"
            value="{{ old('extensions', ($editing ? $fileType->extensions : '')) }}"
            maxlength="255"
            placeholder="Extensions"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
