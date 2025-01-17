<?php
namespace UserMeta\EditDefaultForm;

use UserMeta\Html\Html;

/**
 *
 * @since 1.4
 * @author khaled Hossain
 */
class InputList
{

    private $inputs = [
        'login' => [
            [
                'form_id',
                'form_class',
                'before_form',
                'after_form'
            ],
            [
                'login_label',
                'login_placeholder',
                'login_id',
                'login_class',
                'login_label_class'
            ],
            [
                'pass_label',
                'pass_placeholder',
                'pass_id',
                'pass_class',
                'pass_label_class'
            ],
            [
                'remember_label',
                'remember_id',
                'remember_class'
            ],
            [
                'button_value',
                'button_id',
                'button_class',
                'before_button',
                'after_button'
            ],
            [
                'registration_link_class'
            ]
        ],
        'lostpassword' => [
            [
                'title',
                'form_id',
                'form_class',
                'before_form',
                'after_form',
                'before_div',
                'after_div'
            ],
            [
                'intro_text'
            ],
            [
                'input_label',
                'placeholder',
                'input_id',
                'input_class',
                'input_label_class'
            ],
            [
                'button_value',
                'button_id',
                'button_class',
                'before_button',
                'after_button'
            ]
        ],
        'resetpass' => [
            [
                'title',
                'form_id',
                'form_class',
                'before_form',
                'after_form'
            ],
            [
                'heading',
                'intro_text'
            ],
            [
                'pattern',
                'pattern_rule_text',
                'invalid_pattern_text'
            ],
            [
                'pass1_label',
                'pass1_placeholder',
                'pass1_id',
                'pass1_class',
                'pass1_label_class'
            ],
            [
                'pass2_label',
                'pass2_placeholder',
                'pass2_id',
                'pass2_class',
                'pass2_label_class'
            ],
            [
                'button_value',
                'button_id',
                'button_class',
                'before_button',
                'after_button'
            ]
        ]
    ];

    public function buildInputs($key, $data)
    {
        $inputList = $this->inputs[$key];
        foreach ($inputList as $group) {
            echo "<br />";
            foreach ($group as $input) {
                $val = isset($data[$key][$input]) ? $data[$key][$input] : '';
                $html = Html::text($val, [
                    'name' => "{$key}[{$input}]",
                    'class' => 'form-control',
                    'placeholder' => 'Leave it blank to use default',
                ]);
                echo "<div class='form-group row'><label>$input</label>$html</div>";
            }
        }
    }
}