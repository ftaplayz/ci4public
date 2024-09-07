<?php
function htmlRulesToCI(array $htmlRules): string{
    $ruleString = '';
    $alreadyHas = [];
    for($iterator = new \App\Core\Iterator($htmlRules);!$iterator->isDone();$iterator->next()){
        $rule = $iterator->key();
        $value = $iterator->current();
        if(array_search($rule, $alreadyHas))
            continue;
        $notAdded = false;
        switch($rule){
            case 'required':
                $ruleString .= 'required';
                break;
            case 'minlength':
                $ruleString .= "min_length[$value]";
                break;
            case 'maxlength':
                $ruleString .= "max_length[$value]";
                break;
            case 'type':
                switch($value){
                    case 'number':
                        if(array_key_exists('step', $htmlRules) && is_numeric($htmlRules['step']) && ($htmlRules['step'] - floor($htmlRules['step']) != 0)){
                            $alreadyHas[] = 'step';
                            $ruleString .= 'decimal';
                        }else
                            $ruleString .= 'integer';
                        break;
                    case 'email':
                        $ruleString .= 'valid_email';
                        break;
                    default:
                        $notAdded = true;
                }
                break;
            default:
                $notAdded = true;
        }
        if(!$notAdded)
            $ruleString .= '|';
        $alreadyHas[] = $rule;
    }
    if(!empty($ruleString))
        $ruleString = rtrim($ruleString, '|');
    return $ruleString;
}