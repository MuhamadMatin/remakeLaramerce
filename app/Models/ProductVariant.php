<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  public $timestamps = true;

  protected $primaryKey = 'id_product_variant';

  protected $keyType = 'string';

  protected $table = 'product_variants';

  protected $fillable = [
    'id_product_variant',
    'name',
    'slug',
    'description',
    'is_variant_active',
    'image_path',
    'sku',
    'stock',
    'price',
    'color',
    'size',
    'product_id',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  protected $casts = [
    'is_active' => 'boolean',
    'stock'     => 'integer',
    'price'     => 'integer',
  ];

  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class, 'product_id', 'id_product');
  }

  public function images(): HasMany
  {
    return $this->hasMany(ProductImage::class, 'product_variant_id', 'id_product_variant');
  }
}
