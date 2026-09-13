<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
  use HasFactory, SoftDeletes;
  public $incrementing = false;

  public $timestamps = true;

  protected $primaryKey = 'id_product_image';

  protected $keyType = 'string';

  protected $table = 'product_images';

  protected $fillable = [
    'id_product_image',
    'image_path',
    'is_primary',
    'product_variant_id',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  protected $casts = [
    'is_primary' => 'boolean',
  ];

  public function variant(): BelongsTo
  {
    return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id_product_variant');
  }
}
