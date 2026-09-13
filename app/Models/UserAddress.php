<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  public $timestamps = true;

  protected $primaryKey = 'id_user_address';

  protected $keyType = 'string';

  protected $table = 'user_addresses';

  protected $fillable = [
    'id_user_address',
    'address',
    'zip_code',
    'province_id',
    'subdistrict_id',
    'city_id',
    'label',
    'is_primary',
    'user_id',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  protected $casts = [
    'is_primary' => 'boolean',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id_user');
  }
}
