<div>
    <div class="mb-4">
        @can('create', App\Models\File::class)
        <button class="btn btn-primary" wire:click="newFile">
            <i class="icon ion-md-add"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\File::class)
        <button
            class="btn btn-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="icon ion-md-trash"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal id="file-type-files-modal" wire:model="showingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $modalTitle }}</h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <x-inputs.group class="col-sm-12 col-md-6">
                        <x-inputs.partials.label
                            name="fileFileName"
                            label="File Name"
                        ></x-inputs.partials.label
                        ><br />

                        <input
                            type="file"
                            name="fileFileName"
                            id="fileFileName{{ $uploadIteration }}"
                            wire:model="fileFileName"
                            class="form-control-file"
                        />

                        @if($editing && $file->file_name)
                        <div class="mt-2">
                            <a
                                href="{{ \Storage::url($file->file_name) }}"
                                target="_blank"
                                ><i class="icon ion-md-download"></i
                                >&nbsp;Download</a
                            >
                        </div>
                        @endif @error('fileFileName')
                        @include('components.inputs.partials.error') @enderror
                    </x-inputs.group>

                    <x-inputs.group class="col-sm-12 col-md-6">
                        <x-inputs.select
                            name="file.user_id"
                            label="User"
                            wire:model="file.user_id"
                        >
                            <option value="null" disabled>Please select the User</option>
                            @foreach($fileTypeUsers as $value => $label)
                            <option value="{{ $value }}"  >{{ $label }}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>
                </div>
            </div>

            @if($editing) @endif

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light float-left"
                    wire:click="$toggle('showingModal')"
                >
                    <i class="icon ion-md-close"></i>
                    @lang('crud.common.cancel')
                </button>

                <button type="button" class="btn btn-primary" wire:click="save">
                    <i class="icon ion-md-save"></i>
                    @lang('crud.common.save')
                </button>
            </div>
        </div>
    </x-modal>

    <div class="table-responsive">
        <table class="table table-borderless table-hover">
            <thead>
                <tr>
                    <th>
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="text-left">
                        @lang('crud.file_type_files.inputs.file_name')
                    </th>
                    <th class="text-left">
                        @lang('crud.file_type_files.inputs.user_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($files as $file)
                <tr class="hover:bg-gray-100">
                    <td class="text-left">
                        <input
                            type="checkbox"
                            value="{{ $file->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="text-left">
                        @if($file->file_name)
                        <a
                            href="{{ \Storage::url($file->file_name) }}"
                            target="blank"
                            ><i class="icon ion-md-download"></i
                            >&nbsp;Download</a
                        >
                        @else - @endif
                    </td>
                    <td class="text-left">
                        {{ optional($file->user)->name ?? '-' }}
                    </td>
                    <td class="text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $file)
                            <button
                                type="button"
                                class="btn btn-light"
                                wire:click="editFile({{ $file->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">{{ $files->render() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
