<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use HasFactory, SoftDeletes;

  public $incrementing = false;

  public $timestamps = true;

  protected $primaryKey = 'id_owner';

  protected $keyType = 'string';

  protected $table = 'owners';

  protected $fillable = [
    'id_owner',
    'user_id',
    'store_id',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id_user');
  }

  public function store(): BelongsTo
  {
    return $this->belongsTo(Store::class, 'store_id', 'id_store');
  }
}
