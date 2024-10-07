<?PHP
namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function successResponse($data_name, $data, $message, $statusCode): JsonResponse
    {
        return response()->json([
            $data_name => $data,
            'message' => $message,
        ], $statusCode);
    }
    public static function errorResponse($data, $message, $statusCode)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }
}
