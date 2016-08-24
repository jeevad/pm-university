<?php

namespace App\Traits;

use Illuminate\Http\Response as IlluminateResponse;

trait ApiControllerTrait
{
    /**
     * @var int
     */
    protected $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * @var string
     */
    protected $responseFormat = 'json';

    /**
     * @var array Array to convert
     */
    protected $_data = [];

    /**
     * @param type $format
     *                     return string
     */
    public function setResponseFormat($format)
    {
        $this->responseFormat = $format;

        return $this;
    }

    /**
     * @return string
     */
    public function getResponseFormat()
    {
        return $this->responseFormat;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param
     *            $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondNotFound($message = 'Requested resource not found')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondBadRequest($message = 'Bad Request')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_BAD_REQUEST)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondServerError($message = 'Server Error')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondConflict($message = 'Conflict')
    {
        return $this->setStatusCode(Response::HTTP_CONFLICT)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_FORBIDDEN)->respondWithError($message);
    }

    /**
     * @param
     *            $message
     *
     * @return mixed
     */
    public function respondCreated($message, array $data = [], array $headers = [])
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->respondWithSuccess($message, $data, $headers);
    }

    /**
     * @param
     *            $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondOk($message)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_OK)->respondWithSuccess($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondWithValidationError($message, array $data = [])
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message, $data);
    }

    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithSuccess($message, array $data = [], array $headers = [])
    {
        $response = [
            'httpCode' => $this->getStatusCode(),
            'success'  => true,
            'message'  => $message,
        ];
        if (!empty($data)) {
            $response['data'] = $data;
        }

        return $this->respond($response, $headers);
    }

    /**
     * @param type  $message
     * @param array $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message, array $data = [], array $headers = [])
    {
        $response = [
            'httpCode' => $this->getStatusCode(),
            'success'  => false,
            'message'  => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return $this->respond($response, $headers);
    }

    /**
     * @param
     *            $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($response, $headers = [])
    {
        if ($this->responseFormat === 'xml') {
            $headers['Content-Type'] = 'application/xml';

            return response($this->toXml($response), $this->getStatusCode(), $headers);
        }

        return response()->json($response, $this->getStatusCode(), $headers, JSON_NUMERIC_CHECK);
    }

    public function respondWithCORS($data)
    {
        return $this->respond($data, $this->setCORSHeaders());
    }

    private function setCORSHeaders()
    {
        $header['Access-Control-Allow-Origin'] = '*';
        $header['Allow'] = 'GET, POST, OPTIONS';
        $header['Access-Control-Allow-Headers'] = 'Origin, Content-Type, Accept, Authorization, X-Request-With';
        $header['Access-Control-Allow-Credentials'] = 'true';

        return $header;
    }

    /**
     * Convert response to XMl format.
     *
     * @param mixed  $data
     * @param mixed  $structure
     * @param string $basenode
     *
     * @return string
     */
    public function toXml($data = null, $structure = null, $basenode = 'xml')
    {
        if ($data === null and !func_num_args()) {
            $data = $this->_data;
        }

        // turn off compatibility mode as simple xml throws a wobbly if you don't.
        if (ini_get('zend.ze1_compatibility_mode') == 1) {
            ini_set('zend.ze1_compatibility_mode', 0);
        }

        if ($structure === null) {
            $structure = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$basenode />");
        }

        // Force it to be something useful
        if (!is_array($data) and !is_object($data)) {
            $data = (array) $data;
        }

        foreach ($data as $key => $value) {

            // change false/true to 0/1
            if (is_bool($value)) {
                $value = (int) $value;
            }

            // no numeric keys in our xml please!
            if (is_numeric($key)) {
                // make string key...
                $key = (str_singular($basenode) != $basenode) ? str_singular($basenode) : 'item';
            }

            // replace anything not alpha numeric
            $key = preg_replace('/[^a-z_\-0-9]/i', '', $key);

            if ($key === '_attributes' && (is_array($value) || is_object($value))) {
                $attributes = $value;
                if (is_object($attributes)) {
                    $attributes = get_object_vars($attributes);
                }

                foreach ($attributes as $attributeName => $attributeValue) {
                    $structure->addAttribute($attributeName, $attributeValue);
                }
            }  // if there is another array found recursively call this function
elseif (is_array($value) || is_object($value)) {
    $node = $structure->addChild($key);

                    // recursive call.
                    $this->toXml($value, $node, $key);
} else {
    // add single node.
                    $value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');

    $structure->addChild($key, $value);
}
        }

        return $structure->asXML();
    }
}
