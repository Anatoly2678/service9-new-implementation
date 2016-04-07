<?php

class Model_Invoice extends Model {
    public function get_data_step1() {
        $query="SELECT pt.TarifID,pt.TarifName,ptf.FormType,ptf.FormDefaultValue,ptf.FormValue,ptf.FormAlias FROM pay_tarif_form ptf INNER JOIN pay_tarif pt
  ON ptf.TarifID=pt.TarifID WHERE ptf.TarifFormSubID IS NULL AND ptf.FormIsHidden=false";
        $selectResult=$this->get_data_real($query);
        $sqli=$this->getSelfSQLI();
	$query = $sqli->store_result();
        $resutl='';
	while ($row = $query->fetch_assoc()) {
            $resutl .=$this->draw_html($row);            
        }
        return $resutl;
    }
    
    public function get_data_step4_individual() {
        $html='';
        $labelSize=2;
        $form_array=array(
            '1'=>array ('label'=>'ФИО','input'=>array(array('type'=>'input','size'=>'10','placeholder'=>'Полностью'))),
            '2'=>array ('label'=>'Паспорт','input'=>array(array('type'=>'input','size'=>'5','placeholder'=>'Серия'),
                array('type'=>'input','size'=>'5','placeholder'=>'Номер'))),
            '3'=>array ('label'=>'Выдан','input'=>array(array('type'=>'input','size'=>'3','placeholder'=>'ХХ.ХХ.ХХХХ'),
                array('type'=>'input','size'=>'7','placeholder'=>'Название органа, выдавшего паспорт'))),
            '4'=>array ('label'=>'Адрес регистрации','input'=>array(array('type'=>'input','size'=>'3','placeholder'=>'Город'),
                array('type'=>'input','size'=>'7','placeholder'=>'Улица, дом, корп., кв.'))),
            '5'=>array ('label'=>'Телефон','input'=>array(array('type'=>'input','size'=>'10','placeholder'=>'Полностью, без пробелов и тире'))),
            '6'=>array ('label'=>'E-mail','input'=>array(array('type'=>'input','size'=>'10','placeholder'=>'Ваш действующий электронный адрес')))
        );
        return $this->get_form_from_array($labelSize,$form_array,'individualAccount');
    }
    
    public function get_data_step4_legalEntity() {
        $html='';
        $labelSize=4;
        $form_array=array(
            '1'=>array ('label'=>'Наименование, орг.форма','input'=>array(array('type'=>'input','size'=>'8','placeholder'=>'Например: СЕРВИС9, OOO'))),
            '2'=>array ('label'=>'ИНН / КПП / ОГРН','input'=>array(array('type'=>'input','size'=>'2','placeholder'=>'XXXXXXXXXX'),
                array('type'=>'input','size'=>'3','placeholder'=>'XXXXXXXXX'),
                array('type'=>'input','size'=>'3','placeholder'=>'XXXXXXXXXXXXXX'))),
            '3'=>array ('label'=>'р/сч','input'=>array(array('type'=>'input','size'=>'8','placeholder'=>'XXXXXXXXXXXXXXXXXXXX'))),
            '4'=>array ('label'=>'к/сч / БИК','input'=>array(array('type'=>'input','size'=>'4','placeholder'=>'XXXXXXXXXXXXXXXXXXXX'),
                array('type'=>'input','size'=>'4','placeholder'=>'XXXXXXXX'))),
            '5'=>array ('label'=>'Банк','input'=>array(array('type'=>'input','size'=>'8','placeholder'=>'Банк, город'))),
            '6'=>array ('label'=>'Юридический адрес','input'=>array(array('type'=>'input','size'=>'2','placeholder'=>'Индекс'),
                array('type'=>'input','size'=>'3','placeholder'=>'Город'),
                array('type'=>'input','size'=>'3','placeholder'=>'Улица, дом, офис'))),
            '7'=>array ('label'=>'Фактический адрес','input'=>array(array('type'=>'input','size'=>'8','placeholder'=>'Если не совпадает с Юр. адресом','class'=>'novalidate'))),
            '8'=>array ('label'=>'Почтовый адрес','input'=>array(array('type'=>'input','size'=>'8','placeholder'=>'Если не совпадает с Юр. адресом','class'=>'novalidate'))),
            '9'=>array ('label'=>'ФИО руководителя','input'=>array(array('type'=>'input','size'=>'8','placeholder'=>'Полностью'))),
            '10'=>array ('label'=>'Телефон / E-mail','input'=>array(array('type'=>'input','size'=>'4','placeholder'=>'Полностью, без пробелов и тире'),
                array('type'=>'input','size'=>'4','placeholder'=>'Ваш действующий электронный адрес')))
        );
        return $this->get_form_from_array($labelSize,$form_array,'legalEntityAccount');
    }
    
    private function get_form_from_array($labelSize,$form_array,$nameform) {
        ksort($form_array);
        $html .='<form class="form-horizontal invoice-hide" role="form" name="'.$nameform.'" id="'.$nameform.'">';
        foreach ($form_array as $key => $value) {
                $html .=$this->draw_html_step4($value,$labelSize);
        }
        $html .='</form>';
        return $html;
    }

        private function draw_html_step4($row,$labelSize) {
        $result = count($row['input']);
        $html ='';
        $html .='<div class="form-group ">';
        $html .='<label class="col-xs-'.$labelSize.' control-label">'.$row['label'].'</label>';
        if ($result>1) {
            foreach ($row['input'] as $input) {
                $html .='<div class="col-xs-'.$input['size'].' invoice-validate">';
                $html .='<input type="text" class="form-control '.$input['class'].'" placeholder="'.$input['placeholder'].'">';
                $html .='</div>';
            } 
        } else {
            $html .='<div class="col-xs-'.$row['input'][0]['size'].' invoice-validate">';
            $html .='<input type="text" class="form-control '.$row['input'][0]['class'].'" placeholder="'.$row['input'][0]['placeholder'].'">';
            $html .='</div>';
        }
        $html .='</div>';
        return $html;
    }

    private function draw_html($row) {
        $html='';
        $html .= '<div class="input-group" id='.$row[TarifID].'>';
        $html .= '<div class="form-group col-xs-5">';
        $html .= '<div class="input-group">';
        $html .= '<span class="input-group-addon">';
        $html .= '<input type="checkbox">';
        $html .= '</span>';
        $html .= '<fieldset disabled>';
        $html .= '<input type="text" id="disabledTextInput" class="form-control right-radius" value="'.$row[TarifName].'" title="'.$row[TarifName].'">';
        $html .= '</fieldset>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="form-group col-xs-1 invoice-align-right">';
        $html .= '<label class="form-control control-label">Х</label>';
        $html .= '</div>';
        $html .= '<div class="form-group col-xs-4 invoice-validate">';
        $html .= $this->get_control($row[FormType], $row[FormDefaultValue], $row[FormValue]);
        $html .= '</div>';
        $html .= '<div class="form-group col-xs-2">';
        $html .= '<label class="form-control control-label">'.$row[FormAlias].'</label>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
    
    private function get_control($controlType,$controlValue,$controlPrice=null) {
        $return='';
        switch ($controlType) {
            case 'select':
                $valueElement = explode(";", $controlValue);
                $return='<select class="inputElem form-control right-radius left-radius" default="'.$valueElement[0].'" price="'.$controlPrice.'" disabled>';
                foreach ($valueElement as $value) {
                    $return .='<option>'.$value.'</option>';
                }
                $return .='</select>';
                break;
            case 'input':
                $return='<input type="text" class="inputElem form-control right-radius left-radius" default="" placeholder="введите значение" disabled>';
                break;
        }
        return $return;
    }
}

?>
