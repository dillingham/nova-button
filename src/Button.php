<?php

namespace NovaButton;

use Laravel\Nova\Fields\Field;

class Button extends Field
{
    public $classes = [];

    public $style = 'link';
    
    public $showOnUpdate = false;

    public $showOnCreation = false;

    public $visible = true;

    public $successMessage = "Complete!";

    public $errorMessage = "Whoops!";
    
    public $component = 'nova-button';

    public $event = "NovaButton\Events\Click";

    public $text = "Click Me";

    public function __construct($name, $key = null)
    {
        $this->name = $name;
        $this->text = $name;
        $this->key = $key ?? kebab_case($name);
    }

    public function resolveForDisplay($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);

        $this->classes[] = 'nova-button-' . strtolower(class_basename($resource));

        $this->classes[] = array_get(config('nova-button.styles'), $this->style);
        
        $this->withMeta([
            'key'     => $this->key,
            'text'    => $this->text,
            'event'   => $this->event,
            'classes' => $this->classes,
            'visible' => $this->visible,
            'successMessage' => $this->successMessage,
            'errorMessage' => $this->errorMessage,
        ]);
    }
    
    public function style($style)
    {
        $this->style = $style;

        return $this;
    }

    public function classes($classes)
    {
        $this->classes = $classes;

        return $this;
    }

    public function event($event)
    {
        $this->event = $event;

        return $this;
    }

    public function visible($condition)
    {
        $this->visible = $condition;

        return $this;
    }

    public function update($update)
    {
        $this->update = $update;

        return $this;
    }
}
