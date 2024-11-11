<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidationMessageController extends Controller
{
    public function messageGenerate(Request $request){
        try {


        $field = request()->field;
        $rules = request()->rules;
        $arr = [];


        $single_rule = explode('|', $rules);


        foreach ($single_rule as $rule){
            $string = explode(':', $rule);
            $rule_name = $rule_message_key = $string[0];

            if (in_array($rule_name, ['max', 'min'])){
                $rule_message_key = $rule_message_key.'.string';
            }

            $message = __('validation.'.$rule_message_key);

            $field_string = str_replace('_', ' ', $field);

            $message = str_replace(
                [':attribute', ':ATTRIBUTE', ':Attribute'],
                [$field_string, \Illuminate\Support\Str::upper($field_string), \Illuminate\Support\Str::ucfirst($field_string)],
                $message
            );
            if (in_array($rule_name, ['max', 'min'])){
                $message = str_replace(
                    [':'.$rule_name],
                    [$string[1]],
                    $message
                );
            }

            if ($rule_name == 'required_if'){
                $ex = explode(',', $string[1]);
                $message = str_replace(
                    [':other'],
                    [str_replace('_', ' ', $ex[0])],
                    $message
                );
                if (isset($ex[2])){
                    $message = str_replace(
                        [':value', "'"],
                        [str_replace('_', ' ', $ex[2]), ''],
                        $message
                    );
                }  else{
                    $message = str_replace(
                        [':value', "'"],
                        [str_replace('_', ' ', $ex[1]), ''],
                        $message
                    );
                }
            }

            if ($rule_name == 'mimes'){

                $message = str_replace(
                    [':values'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }
            if ($rule_name == 'same'){

                $message = str_replace(
                    [':other'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }
            if ($rule_name == 'required_with'){

                $message = str_replace(
                    [':values'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }

            if ($rule_name == 'after_or_equal'){

                $message = str_replace(
                    [':date'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }
            if ($rule_name == 'after'){

                $message = str_replace(
                    [':date'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }


            $arr [$field.'.'.$rule_name] = $message;
        }

        $file =  public_path('/validation.php');
        $languages = include  "{$file}";
        $languages = array_merge($languages, $arr);
        file_put_contents($file, '');
        file_put_contents($file, '<?php return ' . var_export($languages, true) . ';');

        return view('validation-message-generate', compact('field', 'rules', 'arr'));
        } catch (\Exception $e) {
        }
    }
}
