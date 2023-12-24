## Nova Button

Thanks for everyone who used this package and contributed. 

I haven't used Nova in many years so I'm unable to maintain this.

I'm so glad to see active forks though!

- https://github.com/dnwjn/nova-button
- https://github.com/sietse85/nova-button

---

[![Latest Version on Github](https://img.shields.io/github/release/dillingham/nova-button.svg?style=flat-square)](https://packagist.org/packages/dillingham/nova-button)
[![Total Downloads](https://img.shields.io/packagist/dt/dillingham/nova-button.svg?style=flat-square)](https://packagist.org/packages/dillingham/nova-button) [![Twitter Follow](https://img.shields.io/twitter/follow/sir_brian_d?color=%231da1f1&label=Twitter&logo=%231da1f1&logoColor=%231da1f1&style=flat-square)](https://twitter.com/sir_brian_d)

Nova package for rendering buttons on index, detail and lens views.

Use buttons to trigger backend events, navigate nova routes or visit links.

![nova-button](https://user-images.githubusercontent.com/29180903/50742708-dffeb600-11dc-11e9-9eed-36f42166c7c4.png)

### Installation

```bash
composer require dillingham/nova-button
```

### Usage

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

Quick links: [Button Styles](https://github.com/dillingham/nova-button#button-styles) | [Event text / style](https://github.com/dillingham/nova-button#button-state) | [Navigation](https://github.com/dillingham/nova-button#button-navigation) | [CSS classes](https://github.com/dillingham/nova-button#button-classes) | [Lens example](https://github.com/dillingham/nova-button#example)

---

### Backend events

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

### Nova Routes

You can also choose to navigate any of the Nova routes

```php
Button::make('Text')->route('vuejs-route-name', ['id' => 1])
Button::make('Text')->index('App\Nova\User')
Button::make('Text')->detail('App\Nova\User', $this->user_id)
Button::make('Text')->create('App\Nova\User')
Button::make('Text')->edit('App\Nova\User', $this->user_id)
Button::make('Text')->lens('App\Nova\User', 'users-without-confirmation')
```
You can also enable a resource's filters 
```php
Button::make('Text')->index('App\Nova\Order')->withFilters([
    'App\Nova\Filters\UserOrders' => $this->user_id,
    'App\Nova\Filters\OrderStatus' => 'active',
])
```

### Links
```php
Button::make('Text')->link('https://nova.laravel.com')
Button::make('Text')->link('https://nova.laravel.com', '_self')
```

### Visiblity

You will likely want to show or hide buttons depending on model values
```php
Button::make('Activate')->visible($this->is_active == false),
Button::make('Deactivate')->visible($this->is_active == true),
```

Also [field authorization](https://nova.laravel.com/docs/1.0/resources/authorization.html#fields) via canSee() & [showing / hiding fields](https://nova.laravel.com/docs/1.0/resources/fields.html#showing-hiding-fields) hideFromIndex(), etc

### Reload
After events are triggered, reload the page. 

```php
Button::make('Notify')->reload()
```
If you click many buttons, reloading will wait for all buttons to finish.

If an error occurs, it will not reload the page.


### Confirm
You can require a confirmation for descructive actions

```php
Button::make('Cancel Account')->confirm('Are you sure?'),
Button::make('Cancel Account')->confirm('title', 'content'),
Button::make('Cancel Account')->confirm('title', 'content', 'Cancel'),
```

### Button state
When using events, you want visual feedback for the end user.

This is especially useful for long running listeners.

```php
Button::make('Remind User')->loadingText('Sending..')->successText('Sent!')
```

| Event | Text | Style |
| -- | -- | -- |
| loading | `loadingText('Loading..')` | `loadingStyle('grey-outline')` |
| success | `successText('Done!')` | `successStyle('success')` |
| error | `errorText('Failed')` | `errorStyle('danger')` |

Defaults defined in the `nova-button` config. Add methods when you want to change for specific resources


### Button styles

This package makes use of [tailwind-css](https://tailwindcss.com) classes / default: `link`

```php
Button::make('Confirm')->style('primary')
```

| Fill  | Outline | Link |
|---|---|---|
| primary | primary-outline | primary-link |
| success | success-outline | success-link |
| danger | danger-outline | danger-link |
| warning | warning-outline | warning-link |
| info | info-outline | info-link |
| grey | grey-outline | grey-link |

Each key adds classes from the `nova-button` config
```php
'primary' => 'btn btn-default btn-primary'
```

### Style config
Publish the nova-button config to add / edit [available styles & defaults](https://github.com/dillingham/nova-button/blob/master/config/nova-button.php) 
```
php artisan vendor:publish --tag=nova-button -- force
```

### Button classes

You can also add classes manually

```php
Button::make('Refund')->classes('some-class')
```
Also able to style the following css classes

```css
.nova-button
.nova-button-{resource-name}
.nova-button-success
.nova-button-error
.nova-button-loading
```

---

# Example

Use [lenses](https://nova.laravel.com/docs/1.0/lenses/defining-lenses.html) with buttons for a very focused user experience 

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
Register a listener for `\NovaButton\Events\ButtonClick` in your [EventServiceProvider](https://laravel.com/docs/5.7/events)
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
No `key` check required when you register an event for this listener

```php
Button::make('Confirm')->event('App\Events\ConfirmClick')
```

# Telescope inspection

![event-triggered](https://user-images.githubusercontent.com/29180903/50742633-1a1b8800-11dc-11e9-8a2d-5ec70d3fcae4.png)

---

# Author

Hi 👋, Im Brian Dillingham, creator of this Nova package [and others](https://novapackages.com/collaborators/dillingham)

Hope you find it useful. Feel free to reach out with feedback.

Follow me on twitter: [@sir_brian_d](https://twitter.com/sir_brian_d) 
