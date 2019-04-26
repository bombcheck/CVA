<?php

namespace App\Filters;


class FilterConstants
{
    // CLIENT
    const CLIENT_INCLUDES = ['brands', 'campaigns'];
    const CLIENT_EXACT = ['id'];
    const CLIENT_PARTIAL = [
        'name',
        'iwinback_api_key',
        'iwinback_api_secret',
    ];

    // BRAND
    const BRAND_INCLUDES = ['client', 'campaigns', 'users'];
    const BRAND_EXACT = ['id', 'client_id'];
    const BRAND_PARTIAL = ['name'];

    // CAMPAIGN
    const CAMPAIGN_INCLUDES = ['brand', 'client'];
    const CAMPAIGN_EXACT = ['id', 'brand_id', 'client_id'];
    const CAMPAIGN_PARTIAL = [
        'title',
        'description',
        'sms_script',
        'call_script',
        'email_subject',
        'email_html',
    ];

    // USER
    const USER_INCLUDES = ['role', 'brands'];
    const USER_EXACT = ['id', 'role_id', 'client_id'];
    const USER_PARTIAL = [
        'first_name',
        'last_name',
        'username',
        'email',
    ];
}
