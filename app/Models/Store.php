<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  public $timestamps = true;

  protected $primaryKey = 'id_store';

  protected $keyType = 'string';

  protected $table = 'stores';

  protected $fillable = [
    'id_store',
    'name',
    'email',
    'phone_number',
    'description',
    'logo_path',
    'user_id',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  public function owners(): HasMany
  {
    return $this->hasMany(Owner::class, 'store_id', 'id_store');
  }

  public function products(): HasMany
  {
    return $this->hasMany(Product::class, 'store_id', 'id_store');
  }
}
