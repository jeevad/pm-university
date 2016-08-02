<?php
namespace App\Services;

use Illuminate\Validation\Validator;
use App\Models\User;

class CustomValidation extends Validator
{

    public function validateFullName($attribute, $value, $parameters)
    {
        return preg_match("/^[a-zA-Z\.'\s]+$/", $value);
    }

    public function validatePhone($attribute, $value, $parameters)
    {
        return preg_match("/^([0-9\s\-\+\(\)]*)$/", $value);
    }

    /**
     * Validator for alphabetic chracters and spaces.
     *
     * @param type $attribute            
     * @param type $value            
     * @param type $parameters            
     * @return type
     */
    public function validateAlphaSpaces($attribute, $value, $parameters)
    {
        return preg_match('/^[\pL\s.\.]+$/u', $value);
    }

    /**
     * Validator for alphabetic chracters, dash, spaces and numbers.
     *
     * @param type $attribute            
     * @param type $value            
     * @param type $parameters            
     * @return type
     */
    public function validateAlphaSpacesNum($attribute, $value, $parameters)
    {
        return preg_match('/^[\pL\s.\-.0-9]+$/u', $value);
    }

    public function validateApiSecureKey($attribute, $value, $parameters)
    {
        return preg_match('/^[a-z0-9]{32}$/', $value) && $value === env('API_SECURE_KEY');
    }

    public function validateSessionToken($attribute, $value, $parameters)
    {
        return preg_match('/^[a-z0-9]{32}$/', $value);
    }

    public function validateDeviceToken($attribute, $value, $parameters)
    {
        return preg_match('/^[a-zA-Z0-9_-]{32,255}$/', $value);
    }

    public function validateDeviceOs($attribute, $value, $parameters)
    {
        return in_array(strtolower($value), array(
            'android',
            'ios',
            'web'
        ));
    }

    public function validateMacAddress($attribute, $value, $parameters)
    {
        return preg_match('/^[a-zA-Z0-9_-]{10,255}$/', $value);
    }

    public function validateMobileNumber($attribute, $value, $parameters)
    {
        return preg_match('/^[789]\d{9}$/', $value);
    }

    /**
     * Validates user id
     *
     * @param
     *            $attribute
     * @param
     *            $value
     * @param
     *            $parameters
     * @return mixed
     */
    public function validateUserId($attribute, $value, $parameters)
    {
        $user = new User();
        return $user->active()->find($value);
    }

    /**
     * Validates complaint id
     *
     * @param
     *            $attribute
     * @param
     *            $value
     * @param
     *            $parameters
     * @return mixed
     */
    public function validateComplaintId($attribute, $value, $parameters)
    {
        $complaint = new Complaint();
        return $complaint->active()->find($value);
    }

    /**
     * Validates complaint current status and latest status
     *
     * @param
     *            $attribute
     * @param
     *            $value
     * @param
     *            $parameters
     * @return bool
     */
    public function validateCurrentStatusId($attribute, $value, $parameters)
    {
        $complaint = new Complaint();
        $status = $complaint->getComplaintStatus((int) $parameters[0]);
        return (int) $status->status_id !== (int) $value;
    }

    /**
     * Validates complaint status is switchable to another ie.
     * Complaint can be re-opened when it is in re-solved status
     *
     * @param
     *            $attribute
     * @param
     *            $value
     * @param
     *            $parameters
     * @return bool
     */
    public function validateIsStatusSwitchable($attribute, $value, $parameters)
    {
        $complaint = new Complaint();
        $status = $complaint->getComplaintStatus((int) $parameters[0]);
        
        $inputStatusId = (int) $value;
        if ($inputStatusId === 5) {
            return (int) $status->status_id === 4;
        }
        return true;
    }

    /**
     * Validates comment
     *
     * @param
     *            $attribute
     * @param
     *            $value
     * @param
     *            $parameters
     * @return bool
     */
    public function validateCommentDescription($attribute, $value, $parameters)
    {
        return (int) strlen($value) !== 0;
    }

    /**
     * Validates complaint feedback option id
     *
     * @param
     *            $attribute
     * @param
     *            $value
     * @param
     *            $parameters
     * @return mixed
     */
    public function validateFeedbackOptionId($attribute, $value, $parameters)
    {
        $feedback = new FeedbackOption();
        return $feedback->active()->find($value);
    }

    /**
     * Validates Image file dimensions
     *
     * @param type $attribute            
     * @param type $value            
     * @param type $parameters            
     * @return type
     */
    public function validateFileDimension($attribute, $value, $parameters)
    {
        $moduleType = isset($parameters[0]) ? $parameters[0] : 'users';
        return array_key_exists($value, config('image.sizes.' . $moduleType));
    }

    /**
     * Validates Image file dimensions
     *
     * @param type $attribute            
     * @param type $value            
     * @param type $parameters            
     * @return type
     */
    public function validateCommentOptionId($attribute, $value, $parameters)
    {
        $commentOption = new CommentOption();
        return $commentOption->active()->find($value);
    }

    /**
     * Validates Image file dimensions
     *
     * @param type $attribute            
     * @param type $value            
     * @param type $parameters            
     * @return type
     */
    public function validateTempFileId($attribute, $value, $parameters)
    {
        $tmpFile = new TemporaryFile();
        return $tmpFile->active()->find($value);
    }
}