<?php
/**
 * Format form validation error messages
 *
 * @param array $messages
 * @return array
 */
if (!function_exists('formatValidationMessages')) {

    function formatValidationMessages($messages = array())
    {
        $errors = array();
        if ($messages->has('appToken')) {
            $field    = 'appToken';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }
        if ($messages->has('locale')) {
            $field    = 'locale';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }
        if ($messages->has('loginId')) {
            $field    = 'loginId';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }
        if ($messages->has('mobileNumber')) {
            $field    = 'mobileNumber';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }
        if ($messages->has('user.email')) {
            $field    = 'user.email';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }
        if ($messages->has('otpOrPassword')) {
            $field    = 'otpOrPassword';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }
        if ($messages->has('otp')) {
            $field    = 'otp';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }
        if ($messages->has('password')) {
            $field    = 'password';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }
        if ($messages->has('deviceToken')) {
            $field    = 'deviceToken';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }
        if ($messages->has('deviceOs')) {
            $field    = 'deviceOs';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }
        if ($messages->has('macAddress')) {
            $field    = 'macAddress';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }
        if ($messages->has('roleId')) {
            $field    = 'roleId';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }
        if ($messages->has('levelId')) {
            $field    = 'levelId';
            $errors[] = getErrorMessage($field, $messages->first($field));
        }

        return $errors;
    }
}

/**
 * Get error message in array format with internal code
 *
 * @param $field
 * @param string $message
 * @return array
 */
if (!function_exists('getErrorMessage')) {

    function getErrorMessage($field, $message = '')
    {
        $errorMsg[$field] = [
            'field' => $field,
            'message' => $message
        ];
        return $errorMsg[$field];
    }
}


