### Nova Button

---

Overview | Style & UI | Basic Behavior | Events & Listeners | Actions | Extend in Packages

---

Simple button to display on a Nova resource.

```
composer require dillingham/nova-button
```

```php
Button::make('Confirm')
    ->event('App\Events\UserConfirmed')
    ->classes('bg-red text-white'),
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

### Button Event Handling

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
### Easily update a model

```
Button('Confirm')
    ->visible($this->is_confirmed == false)
    ->update(['is_confirmed' => true])
```

### Success & Error Messages

```
Button('Confirm')
    ->visible($this->is_confirmed == false)
    ->successMessage('Confirmed!')
    ->errorMessage('Not confirmed')
```

### Get stylish

```
Button::make('Confirm')->style('primary-outline')
```
Publish the nova-button config to add / edit available styles
```
php artisan vendor:publish --tag=nova-button
```