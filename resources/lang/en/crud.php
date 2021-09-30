<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'file_types' => [
        'name' => 'File Types',
        'index_title' => 'FileTypes List',
        'new_title' => 'New File type',
        'create_title' => 'Create FileType',
        'edit_title' => 'Edit FileType',
        'show_title' => 'Show FileType',
        'inputs' => [
            'mime_type' => 'Mime Type',
            'extensions' => 'Extensions',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'files' => [
        'name' => 'Files',
        'index_title' => 'Files List',
        'new_title' => 'New File',
        'create_title' => 'Create File',
        'edit_title' => 'Edit File',
        'show_title' => 'Show File',
        'inputs' => [
            'file_name' => 'File Name',
            'file_type_id' => 'File Type',
            'user_id' => 'User',
        ],
    ],

    'file_type_files' => [
        'name' => 'FileType Files',
        'index_title' => 'Files List',
        'new_title' => 'New File',
        'create_title' => 'Create File',
        'edit_title' => 'Edit File',
        'show_title' => 'Show File',
        'inputs' => [
            'file_name' => 'File Name',
            'user_id' => 'User',
        ],
    ],

    'user_files' => [
        'name' => 'User Files',
        'index_title' => 'Files List',
        'new_title' => 'New File',
        'create_title' => 'Create File',
        'edit_title' => 'Edit File',
        'show_title' => 'Show File',
        'inputs' => [
            'file_name' => 'File Name',
            'file_type_id' => 'File Type',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
