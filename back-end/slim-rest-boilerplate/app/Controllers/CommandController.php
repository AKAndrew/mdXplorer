<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Includes\ValidationRules as ValidationRules;
use \App\Models\User as User;

class CommandController {
    const COMMAND_UP_VALUE = 2;
    const COMMAND_LEFT_VALUE = 4;
    const COMMAND_RIGHT_VALUE = 6;
    const COMMAND_DOWN_VALUE = 8;
    const COMMAND_STOP_VALUE = 5;
    
    private $logger;
    private $db;
    private $validator;

    // Dependency injection via constructor
    public function __construct($depLogger, $depDB, $depValidator) {
        $this->logger = $depLogger;
        $this->db = $depDB;
        $this->validator = $depValidator;
    }
    
    // POST /command
    // Send command
    public function sendCommand(Request $request, Response $response) {
        var_dump($request);
        return $response->withJson([
            "success" => true,
            "cmd" => $request->getParsedBody(),
        ], 200);
    }
    
    // POST /users/login
    public function login(Request $request, Response $response) {
        $this->logger->addInfo('POST /users/login');
        $data = $request->getParsedBody();
        $errors = [];
        $validator = $this->validator->validate($request, ValidationRules::authPost());
        // Validate input
        if (!$validator->isValid()) {
            $errors = $validator->getErrors();
        }
        // validate username
        if (!$errors && !($user = User::where(['username' => $data['username']])->first())) {
            $errors[] = 'Username invalid';
        }
        // validate password
        if (!$errors && !password_verify($data['password'], $user->password)) {
            $errors[] = 'Password invalid';
        }
        if (!$errors) {
            // No errors, generate JWT
            $token = $user->tokenCreate();
            // return token
            return $response->withJson([
                "success" => true,
                "data" => [
                    "token" => $token['token'],
                    "expires" => $token['expires']
                ]
            ], 200);
        } else {
            // Error occured
            return $response->withJson([
                'success' => false,
                'errors' => $errors
            ], 400);
        }
    }
}