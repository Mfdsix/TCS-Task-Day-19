<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
	use SoftDeletes;
    // use different table name ? add this
    // protected $table = 'blog_custom_name';

    protected $guarded = [
    	'id'
    ];

    public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function category(){
    	return $this->hasOne('App\Models\BlogCategory', 'id', 'category_id');
    }
}
