<?php

namespace PHPMaker2021\Dermateknonew;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * maklon_produk controller
 */
class MaklonProdukController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "MaklonProduk");
    }
}
