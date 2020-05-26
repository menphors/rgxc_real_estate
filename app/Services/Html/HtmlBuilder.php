<?php 

namespace App\Services\Html;

use Illuminate\Routing\UrlGenerator;

class HtmlBuilder extends \Collective\Html\HtmlBuilder
{
    /**
     * Create a new HTML builder instance.
     *
     * @param \Illuminate\Routing\UrlGenerator $url
     */
    public function __construct(UrlGenerator $url = null)
    {
        $this->url = $url;
    }

    public function myLink($url, $title = null, $defualt_class = null, $attributes = [])
    {
        $attributes['class'] = $defualt_class . (isset($attributes['class']) ? ' ' . $attributes['class'] : '');
        return parent::link($url, $title, $attributes);
    }

    public function linkDefault($url, $title = null, $attributes = [])
    {
        return $this->myLink($url, $title, 'btn btn-default', $attributes);
    }

    public function linkPrimary($url, $title = null, $attributes = [])
    {
        return $this->myLink($url, $title, 'btn btn-primary', $attributes);
    }

    public function linkSuccess($url, $title = null, $attributes = [])
    {
        return $this->myLink($url, $title, 'btn btn-success', $attributes);
    }

    public function linkInfo($url, $title = null, $attributes = [])
    {
        return $this->myLink($url, $title, 'btn btn-info', $attributes);
    }

    public function linkWarning($url, $title = null, $attributes = [])
    {
        return $this->myLink($url, $title, 'btn btn-warning', $attributes);
    }

    public function linkDanger($url, $title = null, $attributes = [])
    {
        return $this->myLink($url, $title, 'btn btn-danger', $attributes);
    }

    public function linkIcon($url, $title = null, $linkAttributes = [], $iconAttributes = [])
    {
        //$iconAttributes['class'] = 'fa' . (isset($iconAttributes['class']) ? ' ' . $iconAttributes['class'] : '');
        return $this->toHtmlString('<a href="' . $url . '"' . $this->attributes($linkAttributes) . '><i ' . $this->attributes($iconAttributes) . '></i>' . $title . '</a>');
    }

    public function linkNew($url, $title = 'Create New')
    {
        return $this->toHtmlString('<a href="' . $url . '" class="btn btn-primary" data-toggle="tooltip"
                        title="'.__('Add New').'"><i class="fa fa-plus"></i>' . $title . '</a>');
    }

    public function linkRefresh($url, $title = 'Refresh')
    {
        return $this->toHtmlString('<a href="' . $url . '" class="btn btn-default" data-toggle="tooltip"
                        title="'.__('Refresh').'"><i class="fa fa-refresh"></i>' . $title . '</a>');
    }

    public function linkCancel($url, $title = 'Cancel')
    {
        return $this->toHtmlString('<a href="' . $url . '" class="btn btn-default" data-toggle="tooltip"
                        title="'.__('Cancel').'"><i class="fa fa-reply"></i> ' . $title . '</a>');
    }

    public function linkIconView($url = '#', $linkAttributes = [])
    {
        $linkAttributes['class'] = 'btn btn-primary' . (isset($linkAttributes['class']) ? ' ' . $linkAttributes['class'] : '');
        $linkAttributes['data-toggle'] = "tooltip"; 
        $linkAttributes['title'] = __("Veiw");
        return $this->toHtmlString('<a href="' . $url . '"' . $this->attributes($linkAttributes) . '><i class="fa fa-eye"></i></a>');
    }

    public function linkIconEdit($url = '#', $linkAttributes = [])
    {
        $linkAttributes['class'] = 'btn btn-primary' . (isset($linkAttributes['class']) ? ' ' . $linkAttributes['class'] : '');
        $linkAttributes['data-toggle'] = "tooltip"; 
        $linkAttributes['title'] = __("Edit");
        return $this->toHtmlString('<a href="' . $url . '"' . $this->attributes($linkAttributes) . '><i class="fa fa-pencil"></i></a>');
    }

    public function linkIconDelete($url = '#', $linkAttributes = [])
    {
        $linkAttributes['class'] = 'btn btn-danger btn-simple btn-xs remove' . (isset($linkAttributes['class']) ? ' ' . $linkAttributes['class'] : '');
        $linkAttributes['onclick'] = "deleteItem(this)";
        $linkAttributes['data-toggle'] = "tooltip"; 
        $linkAttributes['title'] = __("Remove");
        return $this->toHtmlString('<a href="' . $url . '"' . $this->attributes($linkAttributes) . '><i class="fa fa-times"></i></a>');
    }

    public function icon($attributes = [], $title = null)
    {
        $attributes['class'] = 'fa' . (isset($attributes['class']) ? ' ' . $attributes['class'] : '');
        return $this->toHtmlString('<i ' . $this->attributes($attributes) . '>' . $title . '</i>');
    }

}