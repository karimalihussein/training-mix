<?php

/*
 * These are some default authentication settings
 */
return [
    'redirect_after_auth' => '/',
    'registration_show_password_same_screen' => true,
    'registration_include_name_field' => true,
    'registration_include_password_confirmation_field' => true,
    'registration_require_email_verification' => true,
    'enable_branding' => true,
    'dev_mode' => true,
    'enable_2fa' => true, // Enable or disable 2FA functionality globally
    'login_show_social_providers' => true,
    'center_align_social_provider_button_content' => true,
    'social_providers_location' => 'bottom',
];
