<?php

namespace App\Models;

use App\Enums\DocumentValidationStatus;
use Illuminate\Database\Eloquent\Model;

class DocumentAnalysis extends Model
{
    protected $table = 'document_analysis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'file_type',
        'verification_result',
        'timestamp'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'verification_result' => DocumentValidationStatus::class,
        'timestamp' => 'timestamp',
    ];
}
