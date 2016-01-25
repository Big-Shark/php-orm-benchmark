<?php

/**
 * @property int id
 * @property string title
 * @property string isbn
 * @property int author_id
 */
class Book extends Illuminate\Database\Eloquent\Model {

    protected $table = 'book';
    public $timestamps = false;

    public function author()
    {
        return $this->belongsTo('author');
    }
}