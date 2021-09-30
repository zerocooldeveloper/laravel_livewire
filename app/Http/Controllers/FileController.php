<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\FileType;
use Illuminate\Http\Request;
use App\Http\Requests\FileStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FileUpdateRequest;

class FileController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', File::class);

        $search = $request->get('search', '');

        $files = File::search($search)
            ->latest()
            ->paginate(5);

        return view('app.files.index', compact('files', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', File::class);

        $fileTypes = FileType::pluck('mime_type', 'id');
        $users = User::pluck('name', 'id');

        return view('app.files.create', compact('fileTypes', 'users'));
    }

    /**
     * @param \App\Http\Requests\FileStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileStoreRequest $request)
    {
        $this->authorize('create', File::class);

        $validated = $request->validated();
        if ($request->hasFile('file_name')) {
            $validated['file_name'] = $request
                ->file('file_name')
                ->store('public');
        }

        $file = File::create($validated);

        return redirect()
            ->route('files.edit', $file)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, File $file)
    {
        $this->authorize('view', $file);

        return view('app.files.show', compact('file'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, File $file)
    {
        $this->authorize('update', $file);

        $fileTypes = FileType::pluck('mime_type', 'id');
        $users = User::pluck('name', 'id');

        return view('app.files.edit', compact('file', 'fileTypes', 'users'));
    }

    /**
     * @param \App\Http\Requests\FileUpdateRequest $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function update(FileUpdateRequest $request, File $file)
    {
        $this->authorize('update', $file);

        $validated = $request->validated();

        if ($request->hasFile('file_name')) {
            if ($file->file_name) {
                Storage::delete($file->file_name);
            }

            $validated['file_name'] = $request
                ->file('file_name')
                ->store('public');
        }

        $file->update($validated);

        return redirect()
            ->route('files.edit', $file)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, File $file)
    {
        $this->authorize('delete', $file);

        if ($file->file_name) {
            Storage::delete($file->file_name);
        }

        $file->delete();

        return redirect()
            ->route('files.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
