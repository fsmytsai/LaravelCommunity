<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLocation extends Model
{
    protected $table = 'post_locations';
    protected $primaryKey = ['post_id', 'place_id'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'post_id', 'place_id', 'location_name'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
