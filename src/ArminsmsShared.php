<?php

namespace Armincms\ArminsmsShared;

use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text; 
use Armincms\Bios\Resource;

class ArminsmsShared extends Resource
{ 
    /**
     * The option storage driver name.
     *
     * @var string
     */
    public static $store = '';

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Armin SMS Shared');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return static::label();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make(__('Username'), 'username')
                ->required()
                ->rules('required'),

            Text::make(__('Password'), 'password')
                ->required()
                ->rules('required'), 

            Text::make(__('body Id'), 'bodyId')
                ->required()
                ->rules('required'), 
        ];
    }

    /**
     * Return the location to redirect the user after update.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return string
     */
    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return tap(parent::redirectAfterUpdate($request, $resource), function() {
            file_put_contents(
                config_path('armin-sms-shared.php'), '<?php return ' .var_export(static::options(), true) .';'
            );
        });
    }
}
