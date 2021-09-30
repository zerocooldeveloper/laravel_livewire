<?php

namespace App\Http\Controllers;

use App\Models\FileType;
use Illuminate\Http\Request;
use App\Http\Requests\FileTypeStoreRequest;
use App\Http\Requests\FileTypeUpdateRequest;

class FileTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FileType::class);

        $search = $request->get('search', '');

        $fileTypes = FileType::search($search)
            ->latest()
            ->paginate(5);

        return view('app.file_types.index', compact('fileTypes', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', FileType::class);

        return view('app.file_types.create');
    }

    /**
     * @param \App\Http\Requests\FileTypeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileTypeStoreRequest $request)
    {
        $this->authorize('create', FileType::class);

        $validated = $request->validated();

        $fileType = FileType::create($validated);

        return redirect()
            ->route('file-types.edit', $fileType)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FileType $fileType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FileType $fileType)
    {
        $this->authorize('view', $fileType);

        return view('app.file_types.show', compact('fileType'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FileType $fileType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FileType $fileType)
    {
        $this->authorize('update', $fileType);

        return view('app.file_types.edit', compact('fileType'));
    }

    /**
     * @param \App\Http\Requests\FileTypeUpdateRequest $request
     * @param \App\Models\FileType $fileType
     * @return \Illuminate\Http\Response
     */
    public function update(FileTypeUpdateRequest $request, FileType $fileType)
    {
        $this->authorize('update', $fileType);

        $validated = $request->validated();

        $fileType->update($validated);

        return redirect()
            ->route('file-types.edit', $fileType)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FileType $fileType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FileType $fileType)
    {
        $this->authorize('delete', $fileType);

        $fileType->delete();

        return redirect()
            ->route('file-types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
