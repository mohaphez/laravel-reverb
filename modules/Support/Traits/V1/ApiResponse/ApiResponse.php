<?php

declare(strict_types=1);

namespace Modules\Support\Traits\V1\ApiResponse;

use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

trait ApiResponse
{
    /**
     * @param JsonResource $resource
     * @param null $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function respondWithResource(JsonResource $resource, $message = null, $statusCode = Response::HTTP_OK, $headers = [])
    {
        return $this->apiResponse(
            [
                'success' => true,
                'result'  => $resource,
                'message' => __($message)
            ],
            $statusCode,
            $headers
        );
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     * @return array
     */
    public function parseGivenData($data = [], $statusCode = Response::HTTP_OK, $headers = [])
    {
        $responseStructure = [
            'success' => $data['success'],
            'message' => $data['message'] ?? null,
            'result'  => $data['result'] ?? null,
        ];

        if (isset($data['errors'])) {
            $responseStructure['errors'] = $data['errors'];
        }

        if (isset($data['status'])) {
            $statusCode = $data['status'];
        }

        if ( ! $data['success']) {
            $responseStructure['error_code'] = $data['error_code'] ?? 1;
        }

        if ($this->checkHasException($data)) {

            if ('production' !== config('app.env') && \config('app.debug')) {
                $responseStructure['exception'] = $this->makeExceptionArray($data['exception']);
            }

            $statusCode = Response::HTTP_OK === $statusCode ? Response::HTTP_INTERNAL_SERVER_ERROR : $statusCode;
        }

        return [
            'content'    => $responseStructure,
            'statusCode' => $statusCode,
            'headers'    => $headers
        ];
    }

    /**
     * Return generic json response with the given data.
     *
     * @param       $data
     * @param int $statusCode
     * @param array $headers
     *
     * @return JsonResponse
     */
    protected function apiResponse($data = [], $statusCode = 200, $headers = [])
    {
        $result = $this->parseGivenData($data, $statusCode, $headers);

        return response()->json(
            $result['content'],
            $result['statusCode'],
            $result['headers']
        );
    }


    /**
     * @param ResourceCollection $resourceCollection
     * @param null $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function respondWithResourceCollection(ResourceCollection $resourceCollection, $message = null, $statusCode = 200, $headers = [])
    {

        return $this->apiResponse(
            [
                'success' => true,
                'result'  => $resourceCollection->response()->getData()
            ],
            $statusCode,
            $headers
        );
    }

    /**
     * Respond with success.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondSuccess($message = '')
    {
        return $this->apiResponse(['success' => true, 'message' => __($message)]);
    }

    /**
     * Respond with created.
     *
     * @param $data
     *
     * @return JsonResponse
     */
    protected function respondCreated($message = 'Created')
    {
        return $this->apiResponse(['success' => true, 'message' => __($message)], Response::HTTP_CREATED);
    }

    /**
     * Respond with no content.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondNoContent($message = 'No Content')
    {
        return $this->apiResponse(['success' => true, 'message' => __($message)], Response::HTTP_NO_CONTENT);
    }

    /**
     * Respond with no content.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondNoContentResource($message = 'No Content Found')
    {
        return $this->respondWithResource(new JsonResource([]), __($message));
    }

    /**
     * Respond with no content.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondNoContentResourceCollection($message = 'No Content Found')
    {
        return $this->respondWithResourceCollection(new ResourceCollection([]), __($message));
    }

    /**
     * Respond with unauthorized.
     *
     * @param ?string $message
     *
     * @return JsonResponse
     */
    protected function respondUnAuthorized($message = 'Unauthorized')
    {
        return $this->respondError(__($message), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Respond with throttle requests.
     *
     * @param ?string $message
     *
     * @return JsonResponse
     */
    protected function respondThrottleRequests($message)
    {
        return $this->respondError(__($message), Response::HTTP_TOO_MANY_REQUESTS);
    }

    /**
     * Respond with error.
     *
     * @param $message
     * @param int $statusCode
     *
     * @param Throwable|null $exception
     * @param bool|null $error_code
     * @return JsonResponse
     */
    protected function respondError($message, int $statusCode = 400, Throwable $exception = null, int $error_code = 1)
    {
        return $this->apiResponse(
            [
                'success'    => false,
                'message'    => __($message) ?? __('There was an internal error, Please try again later'),
                'exception'  => $exception,
                'error_code' => $error_code
            ],
            $statusCode
        );
    }

    /**
     * Respond with forbidden.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondForbidden($message = 'Forbidden')
    {
        return $this->respondError(__($message), Response::HTTP_FORBIDDEN);
    }

    /**
     * Respond with not found.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondNotFound($message = 'Not Found')
    {
        return $this->respondError(__($message), Response::HTTP_NOT_FOUND);
    }

    /**
     * Respond with internal error.
     *
     * @param string $message
     * @param ?Throwable $exception = null
     *
     * @return JsonResponse
     */
    protected function respondInternalError($message = 'Internal Error', ?Throwable $exception = null)
    {
        return $this->respondError(__($message), Response::HTTP_INTERNAL_SERVER_ERROR, $exception);
    }

    protected function respondValidationErrors(ValidationException $exception)
    {
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $exception->getMessage(),
                'errors'  => $exception->errors()
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * Check array data has exception
     *
     * @param array $data
     *
     * @return bool
     */
    protected function checkHasException(array $data): bool
    {
        return isset($data['exception']) && ($data['exception'] instanceof Error || $data['exception'] instanceof Throwable);
    }

    /**
     * make exception array
     *
     * @param Throwable $exception
     *
     * @return array
     */
    protected function makeExceptionArray(Throwable $exception): array
    {
        return [
            'message' => $exception->getMessage(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
            'code'    => $exception->getCode(),
            'trace'   => $exception->getTrace(),
        ];
    }
}
