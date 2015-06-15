<?php

/**
 * Validator class file.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 */

namespace PetraBarus\Yii2\SwitchCaseValidator;

/**
 * Validator provides switch-case-like validator.
 * 
 * Usage
 * 
 * <pre>
 *     public function rules() {
 *          return [
 *             ['status', PetraBarus\Yii2\SwitchCaseValidator\Validator::class,
 *              'cases' => [
 *                  self::STATUS_ACTIVE => [
 *                      ['name', 'required']
 *                  ]
 *                  self::STATUS_INACTIVE => [
 *                      ['name', 'safe']
 *                  ]
 *              ]
 *          ];
 *    }
 * </pre>
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 */
class Validator extends \yii\validators\Validator {
    
    /**
     * <pre>
     *  'cases'=>array(
     *      'image'=>array(
     *           array('file',  'required')  //more validators to apply to the model
     *           array('file',  'file')  //more validators to apply to the model
     *      ),
     *      'video'=>array(
     *          array('url', 'required'),
     *          array('url', 'validVideoUrl'),
     *      )
     *  )
     * </pre>
     * @var array the range of options
     */
    public $cases = [];
    
    /**
     * @var array set of rules to apply when no case is matched.
     */
    public $default = [];

    /**
     * @var boolean whether the comparison is strict (both type and value must be the same)
     */
    public $strict = false;
    
    /**
     * Validates a single attribute.
     * Child classes must implement this method to provide the actual validation logic.
     * @param \yii\base\Model $model the data model to be validated
     * @param string $attribute the name of the attribute to be validated.
     */
    public function validateAttribute(\yii\base\Model $model, $attribute)
    {
        $value = $model->$attribute;
        if ($value === null || $value === '') {
            return;
        }
        $found = false;
        $cases = $this->cases;
        while ((list($case, $validators) = each($cases)) && !$found) {
            if (($this->strict === true) && ($case === $value)) {
                $this->applyValidators($model, $validators);
                $found = true;
            } elseif (($this->strict === false) && ($case == $value)) {
                $this->applyValidators($model, $validators);
                $found = true;
            }
        }
    }
    
    /**
     * Apply validators.
     * 
     * @param \CModel $model
     * @param array $rules
     */
    private function applyValidators(\yii\base\Model $model, $rules)
    {
        $validators = new \ArrayObject();
        foreach ($rules as $rule) {
            if ($rule instanceof Validator) {
                $validators->append($rule);
            } elseif (is_array($rule) && isset($rule[0], $rule[1])) { // attributes, validator type
                $validator = Validator::createValidator($rule[1], $this, (array) $rule[0], array_slice($rule, 2));
                $validators->append($validator);
            } else {
                throw new InvalidConfigException('Invalid validation rule: a rule must specify both attribute names and validator type.');
            }
        }
        foreach($validators as $validator) {
            $validator->validateAttributes($model);
        }
    }
}