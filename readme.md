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
    ->classes('bg-red text-white')
    ->visible($this->confirmed_at == null),
```

### Button Navigation

```
->index('App\Nova\Group')
->detail('App\Nova\Group', $this->group_id)
->create('App\Nova\Group')
->edit('App\Nova\Group', $this->group_id)
->link('https://nova.laravel.com')
```

### Button Event Handling

```
Button::make('Confirm')->event('App\Events\Click')
```

The event will receive the resource model it was triggered from & the key

- `$event->resource`
- `$event->key` "confirm"

Default event If no event is declared:

`NovaButton\Events\CLick`

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