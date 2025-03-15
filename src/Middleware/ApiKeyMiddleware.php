<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Psr7\Response as SlimResponse;

class ApiKeyMiddleware implements MiddlewareInterface {
    public function process(Request $request, Handler $handler): Response {
        putenv("API_KEY=".$_ENV['API_KEY']);
        $apiKey = getenv('API_KEY');        

        $headerApiKey = $request->getHeaderLine('X-API-Key');

        if ($headerApiKey !== $apiKey) {
            $response = new SlimResponse(401);
            $response->getBody()->write(json_encode(['error' => 'Acceso no autorizado']));
            return $response->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
}
