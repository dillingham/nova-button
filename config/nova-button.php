<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Global defaults
    |--------------------------------------------------------------------------
    |
    | This package makes a few assumptions for initial global settings, seen below.
    | Edit these values if you want the defaults to be different globally.
    | Scroll further down for the general Tailwind-CSS classes
    */

    'defaults' => [
        'style' => 'link-primary',
        'loadingStyle' => 'link-grey',
        'loadingText' => 'Loading',
        'successStyle' => 'link-success',
        'successText' => 'Success',
        'errorStyle' => 'link-danger',
        'errorText' => 'Failed',
    ],

    /*
    |--------------------------------------------------------------------------
    | Style options
    |--------------------------------------------------------------------------
    |
    | This key value pair allows you to override the default nova button styles
    | and add entirely new style key value pairs altogether that you need.
    | The css classes below are Tailwind-CSS that are come with Nova.
    |
    */

    'styles' => [
        // Fill
        'success' => 'cursor-pointer btn btn-default bg-success text-white',
        'primary' => 'cursor-pointer btn btn-default btn-primary',
        'warning' => 'cursor-pointer btn btn-default bg-warning text-white',
        'danger' => 'cursor-pointer btn btn-default bg-danger text-white',
        'info' => 'cursor-pointer btn btn-default bg-info text-white',
        'grey' => 'cursor-pointer btn btn-default bg-60 text-white',
        // Outline
        'success-outline' => 'cursor-pointer btn btn-default border border-success text-success',
        'primary-outline' => 'cursor-pointer btn btn-default border border-primary text-primary',
        'warning-outline' => 'cursor-pointer btn btn-default border border-warning text-warning ',
        'danger-outline' => 'cursor-pointer btn btn-default border border-danger text-danger ',
        'info-outline' => 'cursor-pointer btn btn-default border border-info text-info ',
        'grey-outline' => 'cursor-pointer btn btn-default border border-60 text-80 ',
        // Link
        'success-link' => 'cursor-pointer dim inline-block text-success font-bold btn btn-link',
        'primary-link' => 'cursor-pointer dim inline-block text-primary font-bold btn btn-link',
        'warning-link' => 'cursor-pointer dim inline-block text-warning font-bold btn btn-link',
        'danger-link' => 'cursor-pointer dim inline-block text-danger font-bold btn btn-link',
        'info-link' => 'cursor-pointer dim inline-block text-info font-bold btn btn-link',
        'grey-link' => 'cursor-pointer dim inline-block text-60 font-bold btn btn-link',
        // Custom
        'custom' => 'bg-orange',
        
    ],
];
