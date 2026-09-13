<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  public $timestamps = true;

  protected $primaryKey = 'id_product';

  protected $keyType = 'string';

  protected $table = 'products';

  protected $fillable = [
    'id_product',
    'name',
    'slug',
    'is_active',
    'is_featured',
    'description',
    'brand_id',
    'category_id',
    'store_id',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  protected $casts = [];

  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class, 'category_id', 'id_category');
  }

  public function brand(): BelongsTo
  {
    return $this->belongsTo(Brand::class, 'brand_id', 'id_brand');
  }

  public function store(): BelongsTo
  {
    return $this->belongsTo(Store::class, 'store_id', 'id_store');
  }

  public function variants(): HasMany
  {
    return $this->hasMany(ProductVariant::class, 'product_id', 'id_product');
  }
}
