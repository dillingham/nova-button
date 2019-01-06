### Nova Button

Simple button to display on a Nova resource.

```
use NovaButton\Button;
```
```php
Button::make('Confirm'),
```
### Install
```
composer require dillingham/nova-button
```

### Button Navigation

```
->index('App\Nova\Group')
->detail('App\Nova\Group', $this->group_id)
->create('App\Nova\Group')
->edit('App\Nova\Group', $this->group_id)
->lens('App\Nova\Group', 'groups-by-spend')
->link('https://nova.laravel.com')
```

### Button Events

```
Button::make('Confirm')
```
Default event If no event is declared:

`NovaButton\Events\CLick`

The event will receive the resource model it was triggered from & the key

- `$event->resource`
- `$event->key` "confirm"

Adding a custom event

```
Button::make('Confirm')->event('App\Events\Click')
```

### Button visiblity 

You will likely want to show or hide buttons depending on model values
```
Button::make('Activate')->visible($this->is_active == false),
Button::make('Deactivate')->visible($this->is_active == true),
```

### Success & Error Messages

```
Button('Confirm')
    ->successMessage('Confirmed!')
    ->errorMessage('Not confirmed')
```

### Button Styles

This package makes use of tailwind-css classes 
```php
'primary' => 'btn btn-default btn-primary'
```
```
Button::make('Confirm')->style('primary')
```

| Fill  | Outline |
|---|---|
| primary | primary-outline |
| success | success-outline |
| danger | danger-outline |
| warning | warning-outline |
| info | info-outline |
| link | grey-outline |

### Customize styles
Publish the nova-button config to add / edit available styles
```
php artisan vendor:publish --tag=nova-button
```

### Adding classes
```
Button::make('Refund')->classes('some-class')
```
Also can style the following css classes

`.nova-button` and `.nova-button-{resource-name}`