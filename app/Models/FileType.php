<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileType extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['mime_type', 'extensions'];

    protected $searchableFields = ['*'];

    protected $table = 'file_types';

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
