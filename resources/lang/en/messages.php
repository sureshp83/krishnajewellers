<?php


/*
    |--------------------------------------------------------------------------
    | Messages Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */


return [
    'login' => [
        'success' => 'You are logged in successfully',
        'job_expired' => 'Your job was expired',
        'job_not_assign' => 'You are not registered any job, kindly contact to admin',
        'already' => 'We send you mail to offline from other devices',
        'inactive' => 'Your account is inactive',
        'invalid' => 'Invalid login credentials',
        'email_password_not_found' => 'Email or password does not exist',
        'email_not_found' => 'Email does not exist',
        'offline' => 'We send you mail to offline from other devices',
        'admin_not_verify' => 'Admin not verify your profile',
        'not_found_social' => 'Your email address not registred, kindly provide registred account details',
        'password_not_found' => "Please set your password"
    ],
    
    'reset_password' => [
        'old_not_match' => 'Password mismatch',
        'same_as_old' => 'You can not use old password as new password',
        'success' => 'Password has been changed successfully',
        'error' => 'There is some problem to change password'
    ],

    'otp' => [
        'otp_send' => 'OTP sent to your registred email address',
        'otp_verified' => 'Your OTP has been verified',
        'otp_not_verify' => 'Your OTP does not verify',
        'otp_not_found' => 'OTP not found'
    ],

    'signup' => [
        'email_exist' => 'Email address already exist',
        'error' => 'There was some problem to create account'
    ],

    'email_verification' => [
        'user_not_found' => 'User not found',
        'success' => 'Your email verification has been done',
        'error' => 'There is some problem to verify email'
    ],

    'profile' => [
        'admin' => [
            'change_password_success' => 'Your password has been changed successfully',
            'change_password_error' => 'There is some problem to change password',
            'password_not_match' => 'Your current password does not match',
            'profile_update_success' => 'Your profile updated successfully',
            'profile_update_error' => 'There is some problem to update profile'
        ],
    ],

    'countries' => [
        'not_found' => 'Country not found',
        'add' => [
            'success' => 'Country has been created successfully',
            'error' => 'There is some problem to create country'
        ],
        'update' => [
            'success' => 'Country has been updated successfully',
            'error' => 'There is some problem to update country'
        ],
        'delete' => [
            'success' => 'Country has been deleted successfully',
            'error' => 'There is some problem to delete customer'
        ],
        'status' => [
            'success' => 'Country has been :status successfully',
            'error' => 'There is some problem to update status',
        ],

    ],

    'customers' => [
        'not_found' => 'Customer not found',
        'add' => [
            'success' => 'Customer has been created successfully',
            'error' => 'There is some problem to create customer'
        ],
        'update' => [
            'success' => 'Customer has been updated successfully',
            'error' => 'There is some problem to update customer'
        ],
        'delete' => [
            'success' => 'Customer has been deleted successfully',
            'error' => 'There is some problem to delete customer'
        ],
        'status' => [
            'success' => 'Customer has been :status successfully',
            'error' => 'There is some problem to update status',
        ],

    ],

    'sellers' => [
        'not_found' => 'Seller not found',
        'add' => [
            'success' => 'Seller has been created successfully',
            'error' => 'There is some problem to create seller'
        ],
        'update' => [
            'success' => 'Seller has been updated successfully',
            'error' => 'There is some problem to update seller'
        ],
        'delete' => [
            'success' => 'Seller has been deleted successfully',
            'error' => 'There is some problem to delete seller'
        ],
        'status' => [
            'success' => 'Seller has been :status successfully',
            'error' => 'There is some problem to update status',
        ],

        'approval' => [
            'success' => 'Seller has been :status successfully',
            'error' => 'There is some problem to update status',
        ],

    ],

    'categories' => [
        'not_found' => 'Category not found',
        'add' => [
            'success' => 'Category has been created successfully',
            'error' => 'There is some problem to create category'
        ],
        'update' => [
            'success' => 'Category has been updated successfully',
            'error' => 'There is some problem to update category'
        ],
        'delete' => [
            'success' => 'Category has been deleted successfully',
            'error' => 'There is some problem to delete category'
        ],
        'status' => [
            'success' => 'Category has been :status successfully',
            'error' => 'There is some problem to update status',
        ],

    ],

    'products' => [
        'not_found' => 'Product not found',
        'add' => [
            'success' => 'Product has been created successfully',
            'error' => 'There is some problem to create product'
        ],
        'update' => [
            'success' => 'Product has been updated successfully',
            'error' => 'There is some problem to update product'
        ],
        'delete' => [
            'success' => 'Product has been deleted successfully',
            'error' => 'There is some problem to delete product'
        ],
        'status' => [
            'success' => 'Product has been :status successfully',
            'error' => 'There is some problem to update status',
        ],

    ],

    'sliders' => [
        'not_found' => 'Slider not found',
        'add' => [
            'success' => 'Slider has been created successfully',
            'error' => 'There is some problem to create slider'
        ],
        'update' => [
            'success' => 'Slider has been updated successfully',
            'error' => 'There is some problem to update slider'
        ],
        'delete' => [
            'success' => 'Slider has been deleted successfully',
            'error' => 'There is some problem to delete slider'
        ],
        'status' => [
            'success' => 'Slider has been :status successfully',
            'error' => 'There is some problem to update status',
        ],

    ],

    'static_pages' => [
        'aboutus' => [
            'success' => 'About us has been updated successfully',
            'error' => 'There is some problem to update about us',
        ],

        'privacy_policy' => [
            'success' => 'Privacy Policy has been updated successfully',
            'error' => 'There is some problem to update privacy policy',
        ],

        'terms_condition' => [
            'success' => 'Terms & Conditions has been updated successfully',
            'error' => 'There is some problem to update privacy terms & conditions',
        ],

        'return_refund' => [
            'success' => 'Return & Refund policy has been updated successfully',
            'error' => 'There is some problem to update privacy return & refund policy',
        ]
    ],

    'settings' => [
        'success' => 'Setting data has been save successfully'
    ]

];