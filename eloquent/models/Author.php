<?php

/**
 * @property int id
 * @property string first_name
 * @property string last_name
 * @method static find($id)
 */
class Author extends Illuminate\Database\Eloquent\Model {

    protected $table = 'author';
    public $timestamps = false;
}