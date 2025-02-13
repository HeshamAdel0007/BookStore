<?php

namespace App\Helper;

use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class Helpers
{
    // Default messages
    private const SUCCESS_MESSAGE = 'Retrieved successfully.';
    private const NOT_FOUND_MESSAGE = 'Not found. Please try again later.';
    private const SERVER_ERROR_MESSAGE = 'An internal server error occurred. Please try again later.';
    private const LOG_ERRORS_MESSAGE = 'An error occurred during the operation';

    // Default status codes
    private const DEFAULT_SUCCESS_STATUS = Response::HTTP_OK;
    private const DEFAULT_NOT_FOUND_STATUS = Response::HTTP_NOT_FOUND;
    private const DEFAULT_SERVER_ERROR_STATUS = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * Return a standardized success response.
     * @param string|null $message Custom success message. If null, the default message will be used.
     * @param array|object|null $data Data to be included in the response.
     * @param int|null $status HTTP status code. If null, the default status code will be used.
     * @return JsonResponse
     */
    public static function successResponse(string|null $message = null, array|object|null $data = null, int|null $status = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message ?: self::SUCCESS_MESSAGE,
            'data' => $data
        ], $status ?: self::DEFAULT_SUCCESS_STATUS);
    } //end of successResponse

    /**
     * Return a standardized not found response.
     * @param string|null $message Custom not found message. If null, the default message will be used.
     * @param int|null $status HTTP status code. If null, the default status code will be used.
     * @param array|object|null $data Data to be included in the response. Defaults to an empty object.
     * @return JsonResponse
     */
    public static function notFoundResponse(string|null $message = null, int|null $status = null, array|object|null $data = new \stdClass()): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message ?: self::NOT_FOUND_MESSAGE,
            'data' => $data
        ], $status ?: self::DEFAULT_NOT_FOUND_STATUS);
    } //end of notFoundResponse

    /**
     * Return a standardized server error response.
     * @param string|null $message Custom server error message. If null, the default message will be used.
     * @param string|null $error Error details. If null, no error details will be included.
     * @param int|null $status HTTP status code. If null, the default status code will be used.
     * @return JsonResponse
     */
    public static function serverErrorResponse(string|null $message = null, string|null $error = null, int|null $status = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message ?: self::SERVER_ERROR_MESSAGE,
            'error' => $error ?? null,
        ], $status ?: self::DEFAULT_SERVER_ERROR_STATUS);
    } //end of serverErrorResponse

    /**
     * Log error details to the Laravel log file
     * @param \Throwable $exception The exception object containing error details.
     * @param string|null $message Custom log message. If null, the default message will be used.
     * @return void
     */
    public static function logErrorDetails($exception, string|null $message = null): void
    {
        Log::error(
            $message ?: self::LOG_ERRORS_MESSAGE,
            [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]
        );
    } //end of logErrorDetails
} //end of Helpers
