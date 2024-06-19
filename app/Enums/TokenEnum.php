<?php

namespace App\Enums;

enum TokenEnum: string
{
    case ACCESS_TOKEN = 'access_token';
    case REFRESH_TOKEN = 'refresh_token';
    case ISSUE_VERIFY_TOKEN = 'issue-verify-token'; // Validate if the access token is valid.
    case ISSUE_ACCESS_TOKEN = 'issue-access-token'; // Obtain access token.
}
