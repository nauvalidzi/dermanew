<?php

namespace PHPMaker2021\Dermateknonew;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * p_invoice controller
 */
class PInvoiceController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PInvoice");
    }
}
