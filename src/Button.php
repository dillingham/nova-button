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

    public $label = "";

    public $indexName = "";

    public $route = null;

    public $link = null;

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
            'key' => $this->key,
            'type' => $this->type,
            'link' => $this->link,
            'text'  => $this->text,
            'event' => $this->event,
            'label' => $this->label,
            'route' => $this->route,
            'visible' => $this->visible,
            'classes' => $this->classes,
            'indexName' => $this->indexName,
            'errorMessage' => $this->errorMessage,
            'successMessage' => $this->successMessage,
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

    public function successMessage($successMessage)
    {
        $this->successMessage = $successMessage;

        return $this;
    }

    public function errorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function label($label)
    {
        $this->label = $label;

        return $this;
    }

    public function index($namespace)
    {
        $this->route('index', [
            'resourceName' => $namespace
        ]);

        return $this;
    }

    public function detail($namespace, $id)
    {
        $this->route('detail', [
            'resourceName' => $namespace,
            'resourceId' => $id,
        ]);

        return $this;
    }

    public function create($namespace)
    {
        $this->route('create', [
            'resourceName' => $namespace
        ]);

        return $this;
    }

    public function edit($namespace, $id)
    {
        $this->route('edit', [
            'resourceName' => $namespace,
            'resourceId' => $id,
        ]);

        return $this;
    }

    public function lens($namespace, $key)
    {
        $this->route('lens', [
            'resourceName' => $namespace,
            'lens' => $key
        ]);

        return $this;
    }

    public function link($href, $target = '_blank')
    {
        $this->type = 'link';
        $this->link = compact('href', 'target');

        return $this;
    }

    public function route($name, $params)
    {
        $this->type = 'route';

        $this->route = [
            'name' => $name,
            'params' => $params
        ];

        // if ($name != 'index') {
        //     $this->route['params'] = array_merge($this->route['params'], [
        //         'viaResource' => '', // users
        //         'viaResourceId' => '', // id
        //         'viaRelationship' => '' // users
        //         // maybe add in vue instead
        //     ]);
        // }
            
        $this->formatResourceName();
        
        return $this;
    }

    public function formatResourceName()
    {
        $this->route['params']['resourceName'] = strtolower(
            str_plural(class_basename($this->route['params']['resourceName']))
        );
    }
}
