<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable, SoftDeletes;

  public $incrementing = false;

  public $timestamps = true;

  protected $primaryKey = 'id_user';

  protected $keyType = 'string';

  protected $table = 'users';

  protected $fillable = [
    'id_user',
    'name',
    'username',
    'email',
    'password',
    'number_phone',
    'photo',
    'provider_auth',
    'id_auth_user',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password'          => 'hashed',
    ];
  }
}
