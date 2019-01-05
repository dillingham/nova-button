<?php

namespace NovaButton;

use Laravel\Nova\Fields\Field;

class Button extends Field
{
    public $classes = [];

    public $showOnIndex = false;
    
    public $showOnUpdate = false;

    public $showOnCreation = false;

    public $visible = false;

    public $message = "Complete!";
    
    public $component = 'nova-button';

    public $event = "NovaButton\Events\Click";

    public function __construct($name, $key = null)
    {
        $this->name = $name;
        $this->key = $key ?? kebab_case($name);
    }

    public function resolveForDisplay($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);

        $this->classes[] = 'nova-button-' . strtolower(class_basename($resource));
        
        $this->withMeta([
            'event'   => $this->event,
            'classes' => $this->classes,
            'visible' => $this->visible,
            'message' => $this->message,
        ]);
    }
    
    public function style($name)
    {
        $this->classes[] = array_get(config('nova-button.styles'), $name);

        return $this;
    }

    public function classes($classes)
    {
        $this->classes = $classes;

        return $this;
    }

    public function dispatch($event)
    {
        $this->event = $event;

        return $this;
    }

    public function visible($condition)
    {
        $this->visible = $condition;

        return $this;
    }
}
