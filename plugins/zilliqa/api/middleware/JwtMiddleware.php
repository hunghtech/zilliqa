<?php

namespace Zilliqa\Api\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Illuminate\Http\Response;

class JwtMiddleware extends BaseMiddleware {
    
    protected $statusCode = Response::HTTP_OK;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return $this->respondWithError("Tài khoản không tồn tại. <br>Xin vui lòng thử lại.", Response::HTTP_BAD_REQUEST);
        }
        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return $this->respondWithError("Phiên làm việc đã hết hạn. <br>Xin vui lòng đăng nhập lại.", $e->getStatusCode());
        } catch (JWTException $e) {
            return $this->respondWithError("Phiên làm việc đã hết hạn. <br>Xin vui lòng đăng nhập lại.", $e->getStatusCode());
        }
        if (! $user) {
            return $this->respondWithError("Tài khoản không tồn tại. <br>Xin vui lòng thử lại.", $e->getStatusCode());
        }
        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }
    
    protected function respondWithError($message = null, $statusCode = null) {
        $this->statusCode = $statusCode;
        $response = [
            'error' => true,
            'error_code' => $this->statusCode,
            'message' => $message,
        ];

        return $this->respondWithArray($response);
    }

    protected function respondWithArray(array $array, array $headers = []) {
        return response()->json($array, $this->statusCode, $headers);
    }
}
