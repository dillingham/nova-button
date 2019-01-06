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

The event will receive:

- `buttonKey` "confirm"
- `resourceName` "users"
- `resourceId` "2"

Default event If no event is declared:

`NovaButton\Events\ButtonClicked`



### Easily update a model

```
Button('Confirm)
    ->visible($this->is_confirmed == false)
    ->update(['is_confirmed' => true])
```