<?php

namespace NovaButton;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Resource;

class Button extends Field
{
    public $style = null;

    public $classes = [];

    public $reload = false;

    public $visible = true;

    public $showOnUpdate = false;

    public $showOnCreation = false;

    public $component = 'nova-button';

    public $event = "NovaButton\Events\ButtonClick";

    public $text = null;

    public $type = null;

    public $label = null;

    public $title = null;

    public $indexName = null;

    public $route = null;

    public $link = null;

    public $confirm = null;

    public $indexAlign = 'right';

    public $errorText = null;

    public $errorClasses = null;

    public $loadingText = null;

    public $loadingClasses = null;

    public $successText = null;

    public $successClasses = null;

    public function __construct($name, $key = null)
    {
        $this->name = $name;
        $this->text = $name;
        $this->key = $key ?? Str::kebab($name);
        $this->attribute = $this->key;
        $this->config = config('nova-button');
        $this->addDefaultSettings();
    }

    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);

        $this->classes[] = 'nova-button-'.strtolower(class_basename($resource));
        $this->classes[] = Arr::get($this->config, "styles.{$this->style}");
        $this->loadingClasses = Arr::get($this->config, "styles.{$this->loadingStyle}");
        $this->successClasses = Arr::get($this->config, "styles.{$this->successStyle}");
        $this->errorClasses = Arr::get($this->config, "styles.{$this->errorStyle}");

        $this->withMeta([
            'key'            => $this->key,
            'type'           => $this->type,
            'link'           => $this->link,
            'text'           => $this->text,
            'event'          => $this->event,
            'label'          => $this->label,
            'route'          => $this->route,
            'reload'         => $this->reload,
            'confirm'        => $this->confirm,
            'visible'        => $this->visible,
            'classes'        => $this->classes,
            'indexName'      => $this->indexName,
            'title'          => $this->title,
            'indexAlign'     => $this->indexAlign,
            'errorText'      => $this->errorText,
            'errorClasses'   => $this->errorClasses,
            'successText'    => $this->successText,
            'successClasses' => $this->successClasses,
            'loadingText'    => $this->loadingText,
            'loadingClasses' => $this->loadingClasses,
        ]);
    }

    public function style($style)
    {
        $this->style = $style;

        return $this;
    }

    public function loadingStyle($loadingStyle)
    {
        $this->loadingStyle = $loadingStyle;

        return $this;
    }

    public function successStyle($successStyle)
    {
        $this->successStyle = $successStyle;

        return $this;
    }

    public function errorStyle($errorStyle)
    {
        $this->errorStyle = $errorStyle;

        return $this;
    }

    public function classes($classes)
    {
        $this->classes[] = $classes;

        return $this;
    }

    public function confirm($message1 = null, $message2 = null)
    {
        $this->confirm = [
            'title' => __('Confirmation'),
            'body'  => null,
        ];

        if ($message1 && $message2 == null) {
            $this->confirm['body'] = $message1;
        }

        if ($message1 && $message2) {
            $this->confirm['title'] = $message1;
            $this->confirm['body'] = $message2;
        }

        return $this;
    }

    public function reload($reload = true)
    {
        $this->reload = $reload;

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

    public function loadingText($loadingText)
    {
        $this->loadingText = $loadingText;

        return $this;
    }

    public function successText($successText)
    {
        $this->successText = $successText;

        return $this;
    }

    public function errorText($errorText)
    {
        $this->errorText = $errorText;

        return $this;
    }

    public function label($label, $showOnIndex = false)
    {
        $this->label = $label;
        if (!!$showOnIndex) $this->indexName = $label;

        return $this;
    }

    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    public function index($namespace)
    {
        $this->route('index', [
            'resourceName' => $this->normalizeResourceName($namespace),
        ]);

        return $this;
    }

    public function detail($namespace, $id)
    {
        $this->route('detail', [
            'resourceName' => $this->normalizeResourceName($namespace),
            'resourceId'   => $id,
        ]);

        return $this;
    }

    public function create($namespace)
    {
        $this->route('create', [
            'resourceName' => $this->normalizeResourceName($namespace),
        ]);

        return $this;
    }

    public function edit($namespace, $id)
    {
        $this->route('edit', [
            'resourceName' => $this->normalizeResourceName($namespace),
            'resourceId'   => $id,
        ]);

        return $this;
    }

    public function lens($namespace, $key)
    {
        $this->route('lens', [
            'resourceName' => $this->normalizeResourceName($namespace),
            'lens'         => $key,
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
            'name'   => $name,
            'params' => $params,
            'query'  => [],
        ];

        return $this;
    }

    /**
     * Add params to route.
     *
     * @param array $params
     *
     * @return $this
     */
    public function withParams(array $params)
    {
        $this->route['query'] = array_merge($this->route['query'], $params);

        return $this;
    }

    /**
     * Add filters to index view.
     *
     * @param array $filters
     *
     * @return $this
     */
    public function withFilters(array $filters)
    {
        $key = $this->route['params']['resourceName'].'_filter';

        $this->route['query'][$key] = base64_encode(json_encode(collect($filters)->map(function ($value, $key) {
            return [
                'class' => $key,
                'value' => $value,
            ];
        })->values()));

        return $this;
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    protected function normalizeResourceName($namespace)
    {
        return class_exists($namespace) && is_subclass_of($namespace, Resource::class)
            ? $namespace::uriKey() : $namespace;
    }

    public function addDefaultSettings()
    {
        $this->addLinkFallbacks();
        $this->style = Arr::get($this->config, 'defaults.style', 'link-primary');
        $this->loadingText = Arr::get($this->config, 'defaults.loadingText', 'Loading');
        $this->loadingStyle = Arr::get($this->config, 'defaults.loadingStyle', str_replace('primary', 'grey', $this->style));
        $this->errorText = Arr::get($this->config, 'defaults.errorText', 'Error!');
        $this->errorStyle = Arr::get($this->config, 'defaults.errorStyle', str_replace('primary', 'danger', $this->style));
        $this->successText = Arr::get($this->config, 'defaults.successText', 'Success!');
        $this->successStyle = Arr::get($this->config, 'defaults.successStyle', str_replace('primary', 'success', $this->style));
    }

    public function addLinkFallbacks()
    {
        if (!Arr::has($this->config, 'styles.link-primary')) {
            $this->config['styles']['link-primary'] = 'cursor-pointer dim inline-block text-primary font-bold no-underline';
        }

        if (!Arr::has($this->config, 'styles.link-success')) {
            $this->config['styles']['link-success'] = 'cursor-pointer dim inline-block text-success font-bold no-underline';
        }

        if (!Arr::has($this->config, 'styles.link-grey')) {
            $this->config['styles']['link-grey'] = 'cursor-pointer dim inline-block text-grey font-bold no-underline';
        }

        if (!Arr::has($this->config, 'styles.link-danger')) {
            $this->config['styles']['link-danger'] = 'cursor-pointer dim inline-block text-danger font-bold no-underline';
        }
    }
}
