<?php

class Book extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [['title', 'isbn'], 'safe'];
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }
}