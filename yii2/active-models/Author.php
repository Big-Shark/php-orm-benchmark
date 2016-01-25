<?php

class Author extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [['first_name', 'last_name'], 'safe'];
    }

    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['id' => 'author_id']);
    }
}