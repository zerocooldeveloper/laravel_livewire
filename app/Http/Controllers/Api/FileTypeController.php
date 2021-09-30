<?php

namespace App\Http\Controllers\Api;

use App\Models\FileType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FileTypeResource;
use App\Http\Resources\FileTypeCollection;
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
            ->paginate();

        return new FileTypeCollection($fileTypes);
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

        return new FileTypeResource($fileType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FileType $fileType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FileType $fileType)
    {
        $this->authorize('view', $fileType);

        return new FileTypeResource($fileType);
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

        return new FileTypeResource($fileType);
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

        return response()->noContent();
    }
}
