This package adds a DateTime field with support for a global `DateTime` format, syntactic sugar for formatting individual `DateTime` fields and powerful date filters for Index views. It can serve as a base for more extensions and improvements with regard to `DateTime` fields and logic in Laravel's [Nova 4](https://nova.laravel.com).

## Installation
```sh
composer require wdelfuego/nova-datetime
```
  
## Usage

### Formatting `DateTime` fields globally
1. First, publish this package's config file by running:
    ```sh
    php artisan vendor:publish --provider="Wdelfuego\Nova\DateTime\ServiceProvider"
    ```
2. Then, set the format you want to use for all of your `DateTime` fields in `config/nova-datetime.php`, for example:

    ```
    return [
        'globalFormat' => 'Y-M-d H:i:s',
    ];
    ```
3. In your Nova resource, replace all instances of `Laravel\Nova\Fields\DateTime` with instances of `Wdelfuego\Nova\DateTime\Fields\DateTime` by adding this use statement:

   ```
   use Wdelfuego\Nova\DateTime\Fields\DateTime;
   ```

This allows you to apply the global format to all `DateTime` fields in your own Nova resources automatically.

To automatically apply the global `DateTime` format to the 'Action Happened at' column of the action events in your resources' action logs as well, install the [wdelfuego/nova-actions](https://github.com/wdelfuego/nova-actions) package.

### Formatting individual `DateTime` fields
The examples below assume that the Eloquent model used for the Nova resource has an attribute named 'attribute'.

The `withDateFormat` helper is added automatically to all `DateTime` fields in your project (including Nova's own, so you don't have to use a custom DateTime field) and allows you to directly set the format you want the field to be displayed in:

```
    DateTime::make(__('Localized label'), 'attribute')
        ->withDateFormat('d-M-Y, H:i'),
```

It is simple syntactic sugar around the `displayUsing` method that works on DateTime fields [since Nova 4.2.4](https://github.com/laravel/nova-issues/discussions/3929#discussioncomment-2607539).

### Filtering resources by `DateTime` fields

You can use Laravel's native [`filterable`](https://nova.laravel.com/docs/4.0/resources/fields.html#filterable-fields) method on your `DateTime` fields for a standard date range filter or use any combination of the date filters below to give your end users powerful ways to filter their Nova resources from the Index view.

- `OnDate` only shows items where the DateTime field matches a specific date
- `NotOnDate` only shows items where the DateTime field is *not* on a specific date
- `AfterDate` only shows items where the DateTime field is after a specific date
- `AfterOrOnDate` only shows items where the DateTime field is either after or on a specific date
- `NotAfterDate` only shows items where the DateTime field is not after a specific date (this is a fully equivalent alias to `BeforeOrOnDate`)
- `BeforeDate` only shows items where the DateTime field is before a specific date
- `BeforeOrOnDate` only shows items where the DateTime field is either before or on a specific date
- `NotBeforeDate` only shows items where the DateTime field is not before a specific date (this is a fully equivalent alias to `AfterOrOnDate`)

You can add a combination of these filters to the Nova resource to allow end users to define a date range.

For example, you could make a standard date range filter that allows users to exclude a specific date like this:
```
use Wdelfuego\Nova\DateTime\Filters\AfterDate;
use Wdelfuego\Nova\DateTime\Filters\BeforeDate;
use Wdelfuego\Nova\DateTime\Filters\NotOnDate;
```
```
    public function filters(NovaRequest $request)
    {
        return [
            new AfterDate(__('After'), 'attribute'),
            new BeforeDate(__('Before'), 'attribute'),
            new NotOnDate(__('But not on'), 'attribute'),
        ];
    }
```

You can also filter for specific dates only using just a single `OnDate` filter, or force open-ended range filtering by adding just one of the `After` or `Before` filters.

## Support

For any problems, questions or remarks you might have, please open an issue on [GitHub](https://github.com/wdelfuego/nova-datetime).