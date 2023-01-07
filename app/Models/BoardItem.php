<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['title', 'contents', 'is_hidden'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['is_hidden' => 'boolean'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    public function board() {
        return $this->belongsTo(Board::class);
    }

    public function boardComments() {
        return $this->hasMany(BoardComment::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected function isHidden(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_null($value) || isset($value) && $value == 0 ? false : true,
            set: fn ($value) => $value == true ? 1 : 0,
        );
    }
}
