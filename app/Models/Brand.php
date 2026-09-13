<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  public $timestamps = true;

  protected $primaryKey = 'id_brand';

  protected $keyType = 'string';

  protected $table = 'brands';

  protected $fillable = [
    'id_brand',
    'name',
    'slug',
    'image_path',
    'description',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  public function products(): HasMany
  {
    return $this->hasMany(Product::class, 'brand_id', 'id_brand');
  }
}
