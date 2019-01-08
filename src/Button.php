<?php

namespace NovaButton;

use Laravel\Nova\Fields\Field;

class Button extends Field
{
    public $classes = [];

    public $style = 'link';
    
    public $visible = true;

    public $showOnUpdate = false;

    public $showOnCreation = false;

    public $successMessage = "Complete!";

    public $errorMessage = "Whoops!";
    
    public $component = 'nova-button';

    public $event = "NovaButton\Events\ButtonClick";

    public $text = "Click Me";

    public $type = null;

    public $label = null;

    public $indexName = null;

    public $route = null;

    public $link = null;

    public $indexAlign = 'right';

    public function __construct($name, $key = null)
    {
        $this->name = $name;
        $this->text = $name;
        $this->key = $key ?? kebab_case($name);
    }

    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);

        $this->classes[] = 'nova-button-' . strtolower(class_basename($resource));

        if ($this->visible == false) {
            $this->canSee(function () {
                return false;
            });
        }
        
        $this->classes[] = array_get($this->styleConfig(), $this->style);
        
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
            'indexAlign' => $this->indexAlign,
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

    public function styleConfig()
    {
        return array_merge(
            ['link' => 'cursor-pointer dim inline-block text-primary font-bold no-underline'],
            config('nova-button.styles')
        );
    }
}
