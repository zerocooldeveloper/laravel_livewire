<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\File;
use Livewire\Component;
use App\Models\FileType;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserFilesDetail extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public User $user;
    public File $file;
    public $userFileTypes = [];
    public $fileFileName;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New File';

    protected $rules = [
        'fileFileName' => ['nullable', 'file'],
        'file.file_type_id' => ['required', 'exists:file_types,id'],
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->userFileTypes = FileType::pluck('mime_type', 'id');
        $this->resetFileData();
    }

    public function resetFileData()
    {
        $this->file = new File();

        $this->fileFileName = null;
        $this->file->file_type_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newFile()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.user_files.new_title');
        $this->resetFileData();

        $this->showModal();
    }

    public function editFile(File $file)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.user_files.edit_title');
        $this->file = $file;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->file->user_id) {
            $this->authorize('create', File::class);

            $this->file->user_id = $this->user->id;
        } else {
            $this->authorize('update', $this->file);
        }

        if ($this->fileFileName) {
            $this->file->file_name = $this->fileFileName->store('public');
        }

        $this->file->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', File::class);

        collect($this->selected)->each(function (string $id) {
            $file = File::findOrFail($id);

            if ($file->file_name) {
                Storage::delete($file->file_name);
            }

            $file->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetFileData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->user->files as $file) {
            array_push($this->selected, $file->id);
        }
    }

    public function render()
    {
        return view('livewire.user-files-detail', [
            'files' => $this->user->files()->paginate(20),
        ]);
    }
}
