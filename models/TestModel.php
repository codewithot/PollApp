<?php


namespace app\models;


use yii\base\Model;

class TestModel extends Model
{
    public $name;
    public $surname;
    public $email;


    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Please enter your name'],


        ];
    }
}