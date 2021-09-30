@php $editing = isset($file) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.partials.label
            name="file_name"
            label="File Name"
        ></x-inputs.partials.label
        ><br />

        <input
            type="file"
            name="file_name"
            id="file_name"
            class="form-control-file"
        />

        @if($editing && $file->file_name)
        <div class="mt-2">
            <a href="{{ \Storage::url($file->file_name) }}" target="_blank"
                ><i class="icon ion-md-download"></i>&nbsp;Download</a
            >
        </div>
        @endif @error('file_name') @include('components.inputs.partials.error')
        @enderror
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.select name="file_type_id" label="File Type" required>
            @php $selected = old('file_type_id', ($editing ? $file->file_type_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the File Type</option>
            @foreach($fileTypes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 col-lg-6">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $file->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
