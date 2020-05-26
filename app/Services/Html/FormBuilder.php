<?php namespace App\Services\Html;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Request;

class FormBuilder extends \Collective\Html\FormBuilder {

    /**
     * Create a new form builder instance.
     *
     * @param \Illuminate\Routing\UrlGenerator                   $url
     * @param \Illuminate\Html\HtmlBuilder                       $html
     * @param string                                             $csrfToken
     */
    public function __construct(HtmlBuilder $html, UrlGenerator $url, Factory $view, $csrfToken)
    {
        $this->url = $url;
        $this->html = $html;
        $this->view = $view;
        $this->csrfToken = $csrfToken;
    }

    /**
     * Create a submit button with default classes
     *
     * @param null $value
     * @param array $options
     * @return string
     */
    public function mySubmit($value = null, $default_class = null, $options = [])
    {
        $options['class'] = $default_class . (isset($options['class']) ? ' ' . $options['class'] : '');

        return parent::submit($value, $options);
    }

    public function submitDefault($value = null, $options = []) {
        return $this->mySubmit($value, 'btn btn-default', $options);
    }

    public function submitPrimary($value = null, $options = []) {
        return $this->mySubmit($value, 'btn btn-primary', $options);
    }

    public function submitSuccess($value = null, $options = []) {
        return $this->mySubmit($value, 'btn btn-success', $options);
    }

    public function submitInfo($value = null, $options = []) {
        return $this->mySubmit($value, 'btn btn-info', $options);
    }

    public function submitWarning($value = null, $options = []) {
        return $this->mySubmit($value, 'btn btn-warning', $options);
    }

    public function submitDanger($value = null, $options = []) {
        return $this->mySubmit($value, 'btn btn-danger', $options);
    }

    public function submitSave($value = 'Save', $options = ['type' => 'submit']) {
        return $this->myButton('<i class="fa fa-save"></i>&nbsp;'.$value, 'btn btn-primary', $options);
    }

    // End submit

    // Button
    public function myButton($value = null, $default_class = null, $options = [])
    {
        $options['class'] = $default_class . (isset($options['class']) ? ' ' . $options['class'] : '');

        return parent::button($value, $options);
    }

    public function buttonDefault($value = null, $options = []) {
        return $this->myButton($value, 'btn btn-default', $options);
    }

    public function buttonPrimary($value = null, $options = []) {
        return $this->myButton($value, 'btn btn-primary', $options);
    }

    public function buttonSuccess($value = null, $options = []) {
        return $this->myButton($value, 'btn btn-success', $options);
    }

    public function buttonInfo($value = null, $options = []) {
        return $this->myButton($value, 'btn btn-info', $options);
    }

    public function buttonWarning($value = null, $options = []) {
        return $this->myButton($value, 'btn btn-warning', $options);
    }

    public function buttonDanger($value = null, $options = []) {
        return $this->myButton($value, 'btn btn-danger', $options);
    }
    // End button

    /**
     * Generate the textbox, label and error mesage with default classes
     *
     * @param $name
     * @param null $value
     * @param array $options
     * @param array $errors, if > 0, generate error message
     * @param string $label, if not null, generate label
     * @return string
     */
    public function myText($name, $value = null, $label = null, $options = [], $errors = [], $star = false)
    {
        $options['class'] = 'form-control' . (isset($options['class']) ? ' ' . $options['class'] : '');

        $html = '<div class="form-group">';
        if ($label != null) $html .= parent::label($name, $label);
        if ($star) $html .= '<span class="text-danger">&nbsp;*</span>';
        $html .= parent::text($name, $value, $options);
        if (count($errors) > 0) $html .= $errors->first($name, '<span class="text-danger">:message</span>');
        $html .= '</div>';

        return $this->toHtmlString($html);
    }

    /**
     * Generate the password textbox, label and error mesage with default classes
     *
     * @param $name
     * @param array $options
     * @param array $errors, if > 0, generate error message
     * @param string $label, if not null, generate label
     * @return string
     */
    public function myPassword($name, $label = null, $options = [], $errors = [], $star = false)
    {
        $options['class'] = 'form-control' . (isset($options['class']) ? ' ' . $options['class'] : '');

        $html = '<div class="form-group">';
        if ($label != null) $html .= parent::label($name, $label);
        if ($star) $html .= '<span class="text-danger">&nbsp;*</span>';
        $html .= parent::password($name, $options);
        if (count($errors) > 0) $html .= $errors->first($name, '<span class="text-danger">:message</span>');
        $html .= '</div>';

        return $this->toHtmlString($html);
    }

    /**
     * Generate the email textbox, label and error mesage with default classes
     *
     * @param $name
     * @param null $value
     * @param array $options
     * @param array $errors, if > 0, generate error message
     * @param string $label, if not null, generate label
     * @return string
     */
    public function myEmail($name, $value = null, $label = null, $options = [], $errors = [], $star = false)
    {
        $options['class'] = 'form-control' . (isset($options['class']) ? ' ' . $options['class'] : '');

        $html = '<div class="form-group">';
        if ($label != null) $html .= parent::label($name, $label);
        if ($star) $html .= '<span class="text-danger">&nbsp;*</span>';
        $html .= parent::email($name, $value, $options);
        if (count($errors) > 0) $html .= $errors->first($name, '<span class="text-danger">:message</span>');
        $html .= '</div>';

        return $this->toHtmlString($html);
    }

    public function myNumber($name, $value = null, $label = null, $options = [], $errors = [], $star = false)
    {
        $options['class'] = 'form-control' . (isset($options['class']) ? ' ' . $options['class'] : '');

        $html = '<div class="form-group">';
        if ($label != null) $html .= parent::label($name, $label);
        if ($star) $html .= '<span class="text-danger">&nbsp;*</span>';
        $html .= parent::number($name, $value, $options);
        if (count($errors) > 0) $html .= $errors->first($name, '<span class="text-danger">:message</span>');
        $html .= '</div>';

        return $this->toHtmlString($html);
    }

    public function myTextarea($name, $value = null, $label = null, $options = [], $errors = [], $star = false)
    {
        $options['class'] = 'form-control' . (isset($options['class']) ? ' ' . $options['class'] : '');

        $html = '<div class="form-group">';
        if ($label != null) $html .= parent::label($name, $label);
        if ($star) $html .= '<span class="text-danger">&nbsp;*</span>';
        $html .= parent::textarea($name, $value, $options);
        if (count($errors) > 0) $html .= $errors->first($name, '<span class="text-danger"><b>:message</b></span>');
        $html .= '</div>';

        return $this->toHtmlString($html);
    }

    public function myCheckbox($name, $value = 1, $checked = null, $label = null, $options = [])
    {
        $html = '<div class="form-group"><label>';
        $html .= parent::checkbox($name, $value, $checked, $options);
        $html .= '&nbsp;'.$label;
        $html .= '</label></div>';

        return $this->toHtmlString($html);
    }

    /**
     * Generate the select, label and error mesage with default classes
     *
     * @param $name
     * @param null $value
     * @param array $options
     * @param array $errors, if > 0, generate error message
     * @param string $label, if not null, generate label
     * @return string
     */
    public function mySelect($name, $list = [], $selected = null, $label = null, array $selectAttributes = [],
        array $optionsAttributes = [], $errors = [], $star = false)
    {
        $selectAttributes['class'] = 'form-control' . (isset($selectAttributes['class']) ? ' ' . $selectAttributes['class'] : '');

        $html = '<div class="form-group">';
        if ($label != null) $html .= parent::label($name, $label);
        if ($star) $html .= '<span class="text-danger">&nbsp;*</span>';
        $html .= parent::select($name, $list, $selected, $selectAttributes, $optionsAttributes);
        if (!empty($errors)) $html .= $errors->first($name, '<span class="text-danger">:message</span>');
        $html .= '</div>';

        return $this->toHtmlString($html);
    }

    public function selectPublish($name, $selected = 0, $label = null, array $selectAttributes = [],
        array $optionsAttributes = [], $errors = [], $star = false)
    {
        if ($selected)
            $selected = 1;
        else
            $selected = 0;

        $list = [ '1'=> 'Publish','0'=>'Unpublish'];
        return $this->mySelect($name, $list, $selected, $label, $selectAttributes, $optionsAttributes, $errors, $star);
    }

    public function myWorkDay($name,  $selected = null, $label = null, array $selectAttributes = [],
        array $optionsAttributes = [], $errors = [], $star = false)
    {
        $workDay = ['Monday' => 'Monday','Tuesday' => 'Tuesday','Wednesday' => 'Wednesday','Thursday' => 'Thursday','Friday' => 'Friday','Saturday' => 'Saturday','Sunday' => 'Sunday'];

        $selectAttributes['class'] = 'form-control' . (isset($selectAttributes['class']) ? ' ' . $selectAttributes['class'] : '');

        $html = '<div class="form-group">';
        if ($label != null) $html .= parent::label($name, $label);
        if ($star) $html .= '<span class="text-danger">&nbsp;*</span>';
        $html .= parent::select($name, $workDay, $selected, $selectAttributes, $optionsAttributes);
        if (count($errors) > 0) $html .= $errors->first($name, '<span class="text-danger">:message</span>');
        $html .= '</div>';

        return $this->toHtmlString($html);
    }

    public function myWorkTime($name,  $selected = null, $label = null, array $selectAttributes = [],
        array $optionsAttributes = [], $errors = [], $star = false)
    {
        $workTime = $this->halfHourTimes();

        $selectAttributes['class'] = 'form-control' . (isset($selectAttributes['class']) ? ' ' . $selectAttributes['class'] : '');

        $html = '<div class="form-group">';
        if ($label != null) $html .= parent::label($name, $label);
        if ($star) $html .= '<span class="text-danger">&nbsp;*</span>';
        $html .= parent::select($name, $workTime, $selected, $selectAttributes, $optionsAttributes);
        if (count($errors) > 0) $html .= $errors->first($name, '<span class="text-danger">:message</span>');
        $html .= '</div>';

        return $this->toHtmlString($html);
    }

    private function halfHourTimes() {
        $time = [];
        $data = [];
        for( $i = 1;$i < 13; $i ++){
            $time[$i.':00'] = $i.': 00';
            $time[$i.':30'] = $i.': 30';
        }
      
      return $time;
    }

    public function myDate($name, $value = null, $label = null, $options = [], $errors = [], $star = false)
    {
        $options['class'] = 'form-control datepicker' . (isset($options['class']) ? ' ' . $options['class'] : '');

        $html = '<div class="form-group">';
        if ($label != null) $html .= parent::label($name, $label);
        if ($star) $html .= '<span class="text-danger">&nbsp;*</span>';
        $html .= '<div class="input-group">';
        $html .= '<div class="input-group-addon"><i class="fa fa-calendar"></i></div>';
        $html .= parent::text($name, $value, $options);
        $html .= '</div>';
        if (count($errors) > 0) $html .= $errors->first($name, '<span class="text-danger">:message</span>');
        $html .= '</div>';

        return $this->toHtmlString($html);
    }

    public function isOffer($name, $selected = 0, $label = null, array $selectAttributes = [],
        array $optionsAttributes = [], $errors = [], $star = false)
    {
        if ($selected)
            $selected = 1;
        else
            $selected = 0;

        $list = [ '1'=> 'Yes','0'=>'No'];
        return $this->mySelect($name, $list, $selected, $label, $selectAttributes, $optionsAttributes, $errors, $star);
    }

    public function selectProvince($name = 'province_id', $selected = '', $label = null, $horizon = true, $default_list = [], array $selectAttributes = [], array $optionsAttributes = [], $errors = [], $required = false)
    {
        $provinces = app('App\Model\Province\ProvinceRepository');
        $lists = $provinces->lists()->orderby('title')->pluck('title', 'id')->toArray();

        if ($horizon)
            return $this->horizonSelect($name, $default_list + $lists, $selected, $label, $selectAttributes, $optionsAttributes, $errors, $required);
        else
            return $this->mySelect($name, $default_list + $lists, $selected, $label, $selectAttributes, $optionsAttributes, $errors, $required);
    }

    public function horizonSelect($name, $list = [], $selected = null, $label = null, array $selectAttributes = [], array $optionsAttributes = [], $errors = [], $required = false)
    {
        $selectAttributes['class'] = 'form-control' . (isset($selectAttributes['class']) ? ' ' . $selectAttributes['class'] : '');
        
        $has_error = count($errors) > 0 ? ($errors->has($name) ? ' has-error' : '') : '';

        $html = '<div class="input-group mb-3' . $has_error . ($required?' required':''). '">';
        if ($label != null) $html .= parent::label($name, $label, ['class' => 'col-sm-2 control-label']);
        $html .= '<div class="col-sm-10">';
        $html .= parent::select($name, $list, $selected, $selectAttributes, $optionsAttributes);
        if (count($errors) > 0) $html .= $errors->first($name, '<span class="help-block">:message</span>');
        $html .= '</div>';
        $html .= '</div>';

        return $this->toHtmlString($html);
    }

    public function pagination($items) {
      $requestQuery = collect(\Request::all())->map(function($item) {
        return $item==null ? "" : $item;
      })->all();

        if(!empty($items)) { 
            $html = '<div class="float-left" style="padding-top: 5px;">Showing 1 to '.$items->count().' of '.$items->total().'</div>';
            $html .= '<div class="float-right">'.($items->appends($requestQuery)->render()).'</div>';

            return $this->toHtmlString($html);
        }
    }

}