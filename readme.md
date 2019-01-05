# Nova Button

Simple button to display on a Nova resource.

```
composer require dillingham/nova-button
```

```php
Button::make('Confirm')
    ->dispatch('App\Events\UserConfirmed')
    ->classes('bg-red text-white')
    ->visible($this->confirmed_at == null),
```

The event will receive:

- `buttonKey` "confirm"
- `resourceName` "users"
- `resourceId` "2"

Default event If no event is declared:

`NovaButton\Events\ButtonClicked`

