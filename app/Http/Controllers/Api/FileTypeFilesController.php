<?php

namespace App\Http\Controllers\Api;

use App\Models\FileType;
use Illuminate\Http\Request;
use App\Http\Resources\FileResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\FileCollection;

class FileTypeFilesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FileType $fileType
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, FileType $fileType)
    {
        $this->authorize('view', $fileType);

        $search = $request->get('search', '');

        $files = $fileType
            ->files()
            ->search($search)
            ->latest()
            ->paginate();

        return new FileCollection($files);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FileType $fileType
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FileType $fileType)
    {
        $this->authorize('create', File::class);

        $validated = $request->validate([
            'file_name' => ['nullable', 'file'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($request->hasFile('file_name')) {
            $validated['file_name'] = $request
                ->file('file_name')
                ->store('public');
        }

        $file = $fileType->files()->create($validated);

        return new FileResource($file);
    }
}
