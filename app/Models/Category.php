<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  public $timestamps = true;

  protected $primaryKey = 'id_category';

  protected $keyType = 'string';

  protected $table = 'categories';

  protected $fillable = [
    'id_category',
    'name',
    'slug',
    'description',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  public function products(): HasMany
  {
    return $this->hasMany(Product::class, 'category_id', 'id_category');
  }
}
