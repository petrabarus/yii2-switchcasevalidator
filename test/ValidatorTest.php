<?php

class Validator extends PHPUnit_Framework_TestCase {
    
    public function testValidator() {
        $model = new yii\base\DynamicModel(['case', 'field1', 'field2']);
        
        $model->addRule('case',
            PetraBarus\Yii2\SwitchCaseValidator\Validator::class,
            [
                'cases' => [
                    1 => [
                        ['field1', 'required'],
                    ],
                    2 => [
                        ['field1', 'compare', 'compareValue' => 'Test']
                    ],
                    3 => [
                        ['field1', 'compare', 'compareValue' => 'Value 1'],
                        ['field2', 'email']
                    ]
                ]
            ]
        );
        $model->case = 1;
        $model->validate();
        $this->assertTrue($model->hasErrors());
        
        $model->field1 = 'Hello World!';
        $model->validate();
        $this->assertFalse($model->hasErrors());
        
        $model->case = 2;
        $model->validate();
        $this->assertTrue($model->hasErrors());
        
        $model->field1 = 'Test';
        $model->validate();
        $this->assertFalse($model->hasErrors());
        
        $model->case = 3;
        $model->validate();
        $this->assertTrue($model->hasErrors());
        
        $model->field1 = 'Value 1';
        $model->field2 = 'Value 3';
        $model->validate();
        $this->assertTrue($model->hasErrors());
        
        $model->field2 = 'test@example.com';
        $model->validate();
        $this->assertFalse($model->hasErrors());
        
    }
}
