<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreAddress extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  public $timestamps = true;

  protected $primaryKey = 'id_store_address';

  protected $keyType = 'string';

  protected $table = 'store_addresses';

  protected $fillable = [
    'id_store_address',
    'address',
    'zip_code',
    'province_id',
    'subdistrict_id',
    'city_id',
    'label',
    'is_primary',
    'store_id',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  protected $casts = [
    'is_primary' => 'boolean',
  ];

  public function store(): BelongsTo
  {
    return $this->belongsTo(Store::class, 'store_id', 'id_store');
  }
}
