<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\FileResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\FileCollection;

class UserFilesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $files = $user
            ->files()
            ->search($search)
            ->latest()
            ->paginate();

        return new FileCollection($files);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', File::class);

        $validated = $request->validate([
            'file_name' => ['nullable', 'file'],
            'file_type_id' => ['required', 'exists:file_types,id'],
        ]);

        if ($request->hasFile('file_name')) {
            $validated['file_name'] = $request
                ->file('file_name')
                ->store('public');
        }

        $file = $user->files()->create($validated);

        return new FileResource($file);
    }
}
