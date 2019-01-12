### Nova Button

[![Latest Version on Github](https://img.shields.io/github/release/dillingham/nova-button.svg?style=flat-square)](https://packagist.org/packages/dillingham/nova-button)
[![Total Downloads](https://img.shields.io/packagist/dt/dillingham/nova-button.svg?style=flat-square)](https://packagist.org/packages/dillingham/nova-button)

Nova package for rendering buttons on index, detail and lens views.

![nova-button](https://user-images.githubusercontent.com/29180903/50742708-dffeb600-11dc-11e9-9eed-36f42166c7c4.png)

```bash
composer require dillingham/nova-button
```

Use it to trigger backend events, navigate nova routes or visit links.

Comes with alot of flexibility, style options and ability to customize .



```php
use NovaButton\Button;
```
```php
public function fields(Request $request)
{
    return [
        ID::make('ID', 'id')->sortable(),
        Text::make('Name', 'name'),
        Button::make('Notify'),
    ];
}
```

### Button events

By default, clicking the button will trigger a backend event via ajax.

Default event: `NovaButton\Events\ButtonClick`

The event will receive the resource model it was triggered from & the key

- `$event->resource` = `model`
- `$event->key` = `"notify"`

Adding a custom key

```php
Button::make('Notify', 'notify-some-user')
```
Adding a custom event
```php
Button::make('Notify')->event('App\Events\NotifyRequested')
```

You register listeners in your EventServiceProvider

### Button navigation

You can also choose to navigate any of the Nova routes

```php
Button::make('Text')->index('App\Nova\User')
Button::make('Text')->detail('App\Nova\User', $this->user_id)
Button::make('Text')->create('App\Nova\User')
Button::make('Text')->edit('App\Nova\User', $this->user_id)
Button::make('Text')->lens('App\Nova\User', 'users-without-confirmation')
```

Or external links
```php
Button::make('Text')->link('https://nova.laravel.com')
Button::make('Text')->link('https://nova.laravel.com', '_self')
```

### Button visiblity 

You will likely want to show or hide buttons depending on model values
```php
Button::make('Activate')->visible($this->is_active == false),
Button::make('Deactivate')->visible($this->is_active == true),
```

Also [field authorization](https://nova.laravel.com/docs/1.0/resources/authorization.html#fields) via canSee() & [showing / hiding fields](https://nova.laravel.com/docs/1.0/resources/fields.html#showing-hiding-fields) hideFromIndex(), etc 

### Page Reload
After events are triggered, reload the page.

```php
Button::make('Notify')->reload()
```

### Button styles

This package makes use of [tailwind-css](https://tailwindcss.com) classes / default: `link`

```php
Button::make('Confirm')->style('primary')
```

| Fill  | Outline |
|---|---|
| primary | primary-outline |
| success | success-outline |
| danger | danger-outline |
| warning | warning-outline |
| info | info-outline |
| grey | grey-outline |

Each key adds classes from the `nova-button` config
```php
'primary' => 'btn btn-default btn-primary'
```

### Style config
Publish the nova-button config to add / edit [available styles](https://github.com/dillingham/nova-button/blob/master/config/nova-button.php)
```
php artisan vendor:publish --tag=nova-button
```
You can also add classes manually
```php
Button::make('Refund')->classes('some-class')
```
Also able to style the following css classes

`.nova-button` and `.nova-button-{resource-name}`

### Success & Error Messages

Change the text displayed after the ajax event triggers

```php
Button::make('Confirm')
    ->successMessage('Confirmed!')
    ->errorMessage('Not confirmed')
```
---

# Example

Make use of [lenses](https://nova.laravel.com/docs/1.0/lenses/defining-lenses.html) with buttons for a very focused UX

![lens-button](https://user-images.githubusercontent.com/29180903/50742642-31f30c00-11dc-11e9-96c2-e0534e963aed.png)

```php
<?php

namespace App\Nova\Lenses;

class UsersWithoutConfirmation extends Lens
{
    public static function query(LensRequest $request, $query)
    {
        return $query
            ->select(['users.id', 'users.name'])
            ->whereNull('email_verified_at');
    }

    public function fields(Request $request)
    {
        return [
            ID::make('ID', 'id'),
            Text::make('Name', 'name'),
            Button::make('Mark As Confirmed'),
        ];
    }
}
```
Register a listener in [EventServiceProvider](https://laravel.com/docs/5.7/events)
```php
<?php

namespace App\Listeners;

class ConfirmUser
{
    public function handle($event)
    {
        if ($event->key == 'mark-as-confirmed') {
            $event->resource->email_verified_at = now();
            $event->resource->save();
        }
    }
}
```
^ No `key` check needed if you declare an event specifically for this listener 

```php
Button::make('Confirm')->event('App\Events'\ConfirmClick')
```

# Telescope inspection

![event-triggered](https://user-images.githubusercontent.com/29180903/50742633-1a1b8800-11dc-11e9-8a2d-5ec70d3fcae4.png)
