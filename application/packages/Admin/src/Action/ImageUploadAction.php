<?php

namespace Admin\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;
use Zend\Http\PhpEnvironment\Request;
use Zend\Diactoros\Response\JsonResponse;
use UploadHelper\Upload;

/**
 * Class ImageUploadAction.
 */
final class ImageUploadAction
{

    /**
     * IndexAction constructor.
     *
     * @param Template $template template engine
     */
    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Executed when action is called.
     *
     * @param RequestInterface       $request  request
     * @param Response      $response response
     * @param callable|null $next     next middleware
     *
     * @return JsonResponse
     */
    public function __invoke(RequestInterface $request, Response $response, callable $next = null)
    {
        $data = $request->getParsedBody();
        $data += (new Request())->getFiles()->toArray();
        $imagePath = $this->upload->uploadImage($data, 'file');

        return new JsonResponse(['location' => $imagePath]);
    }
}
