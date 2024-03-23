<?php

declare(strict_types=1);

return [
    'authenticate' => [
        'error'      => 'The provided credentials are incorrect.',
        'success'    => 'Authentication successful',
        'registered' => 'Registration successful',
        'logout'     => 'Logout successful. All active sessions have been terminated.'
    ],
    'entity' => [
        'synced'         => 'All :entity have been synced successfully.',
        'list_retrieved' => 'The retrieval of all :entity was successful.',
        'retrieved'      => 'The retrieval of the :entity was successful.',
        'created'        => ':entity has been created successfully.',
        'updated'        => ':entity has been updated successfully.',
        'deleted'        => ':entity has been deleted successfully.',
    ],
    'error' => [
        'not_found'    => 'The :entity could not be found.',
        'bad_request'  => 'Your request contains invalid or bad data.',
        'unauthorized' => 'You are not authorized to perform this action.',
        'forbidden'    => 'You are forbidden from performing this action.',
        'server_error' => 'The server encountered an internal error.',
    ],
];
