<?php

namespace News_Tip;

if ( ! defined( 'ABSPATH' ) ) exit; // Don't allow direct access

class Field_Validator {
    /**
     * Holds the errors
     *
     * @var array
     */
    public $errors = array();

    /**
     * Holds the rules that needs to be validated
     *
     * @var array
     */
    public $rules = array();
    
    /**
     * Holds the actual data that should be validated
     *
     * @var array
     */
    public $data = array();

    public $captcha_verification_errors = array(
        'missing-input-secret'      => 'The secret parameter is missing.',
        'invalid-input-secret'      => 'The secret parameter is invalid or malformed.',
        'missing-input-response'    => 'The response parameter is missing.',
        'invalid-input-response'    => 'The request is invalid or malformed.',
        'bad-request'               => 'The response parameter is invalid or malformed.',
        'timeout-or-duplicate'      => 'The response is no longer valid: either is too old or has been used previously.',
    );

    /**
     * Class constructor
     *
     * @param array $rules
     */
    public function __construct( $rules )
    {
        $this->rules = $rules;
    }

    /**
     * Generates errors based on data and rules
     *
     * @return \News_Tip\Field_Validator
     */
    public function validate( $data )
    {
        $this->data = $data;

        foreach ( $this->rules as $field => $rule ) {
            if ( $rule['required'] ) {
                $this->validateEmpty( $field );
            }
            if ( $rule['email'] ) {
                $this->validateEmail( $field );
            }
            if ( $rule['captcha'] ) {
                $this->validateReCaptcha( $field );
            }
        }
        return $this;
    }

    /**
     * Registers an error if the field is empty
     *
     * @param string $field
     * @return void
     */
    public function validateEmpty( $field )
    {
        if ( empty( $this->data[ $field ] ) ) {
            $this->errors[ $field ] = ucfirst($field) . " is required.";
        }
    }

    /**
     * Registers an error if the field is not a valid email
     *
     * @param string $field
     * @return void
     */
    public function validateEmail( $field )
    {
        if ( ! $this->errors[ $field ] && ! filter_var( $this->data[ $field ], FILTER_VALIDATE_EMAIL ) ) {
            $this->errors[ $field ] = ucfirst($field) . " is not valid.";
        }
    }

    public function validateReCaptcha( $field )
    {
        if ( empty( $secretKey = get_news_tip_settings( 'site_secret_v3' ) )) {
            $secretKey = get_news_tip_settings( 'site_secret' );
        }
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode( $this->data[ $field ] );
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);

        if ( ! $responseKeys['success'] ) {
            $this->errors[ $field ] = $this->captcha_verification_errors[ $responseKeys['error-codes'][0] ];
        }
    }

    /**
     * Check if there is no error
     *
     * @return boolean
     */
    public function is_valid()
    {
        return count( $this->errors ) < 1;
    }

    /**
     * Get validated errors
     *
     * @return array
     */
    public function get_errors()
    {
        return $this->errors;
    }

    /**
     * Generates a JSON format of validated errors for API response
     *
     * @return string
     */
    public function get_error_response()
    {
        return json_encode( array(
            "success" => 0,
            "errors"  => $this->get_errors(),
        ) );
    }
}
