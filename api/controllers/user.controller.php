<?php

declare(strict_types=1);

class UserController extends Controller {

    protected $model;
    protected $router;
    protected $validate;

    public function __construct($data = []) {
       parent::__construct($data);
       $this->model = new User();
       $this->router = new Router($_SERVER['REQUEST_URI']);
       $this->validate = new Validate();
    }

    public function index()
    {
        $this->requests();
        $users = $this->model->getAll();

        if (!$users) {
            $this->sendResponse([
                'message' => 'any users not found',
                'status' => 404,
            ], 404);
        }

        $this->sendResponse([
            'data' => $users,
            'status' => 200,
        ], 200);
    }

    public function store()
    {
        $requests = $this->requests();

        $name = $this->validate->escape($requests['name']);
        $surname = $this->validate->escape($requests['surname']);
        $phone = $this->validate->escape($requests['phone']);
        $email = $this->validate->escape($requests['email']);

        $validateData['name'] = $this->validate->run($name, ['name'], 'length');
        $validateData['surname'] = $this->validate->run($surname, ['surname'], 'length');
        $validateData['phone'] = $this->validate->run($phone, ['phone'],'phone_format');
        $validateData['email'] = $this->validate->run($email, ['email'],'email_format');

        $errors = [
            'errors' => [
                'name' => $validateData['name'],
                'surname' => $validateData['surname'],
                'phone' => $validateData['phone'],
                'email' => $validateData['email'],
            ],
        ];

        $isError = $this->validate->checkErrors($errors, ['name', 'surname', 'phone', 'email']);

        if ($isError) {
            $this->sendResponse([
                'message' => 'created user was fail',
                'errors' => $errors['errors'],
                'status' => 422,
            ], 422);

        } else {
            $this->model->create(
                $name,
                $surname,
                intval($phone),
                $email
            );

            $this->sendResponse([
                'message' => 'user was created successfully',
                'status' => 200,
            ], 200);
        }
    }

    public function show()
    {
        $this->requests();
        $id = $this->router?->getIdFromUrl();

        $user = $this->model->getById($id);

        if (!$user) {
            $this->sendResponse([
                'message' => "user with id: $id not found",
                'status' => 404,
            ], 404);
        }

        $this->sendResponse([
            'message' => "user with id: $id found successfully",
            'data' => $user,
            'status' => 200,
        ], 200);
    }

    public function edit()
    {
        $validateData = [];
        $field = [];
        $id = $this->router?->getIdFromUrl();
        $requests = $this->requests();
        foreach ($requests as $request) {
            $field[$request['field']] = $request['value'];
        }

        $name = $this->validate->escape($field['name']);
        $surname = $this->validate->escape($field['surname']);
        $phone = $this->validate->escape($field['phone']);
        $email = $this->validate->escape($field['email']);

        $validateData['name'] = $this->validate->run($name, ['name'], 'length');
        $validateData['surname'] = $this->validate->run($surname, ['surname'], 'length');
        $validateData['phone'] = $this->validate->run($phone, ['phone'],'phone_format');
        $validateData['email'] = $this->validate->run($email, ['email'], 'email_format');

        $errors = [
            'errors' => [
                'name' => $validateData['name'],
                'surname' => $validateData['surname'],
                'phone' => $validateData['phone'],
                'email' => $validateData['email'],
            ],
        ];

        $isError = $this->validate->checkErrors($errors, ['name', 'surname', 'phone', 'email']);

        if ($isError) {
            $this->sendResponse([
                'message' => "updated user with id: $id was fail",
                'errors' => $errors['errors'],
                'status' => 404
            ], 404);
        } else {
            $this->model->update(
                $name,
                $surname,
                intval($phone),
                $email,
                $id
            );

            $this->sendResponse([
                'message' => "user with id: $id was updated successfully",
                'status' => 200
            ], 200);
        }
    }

    public function delete()
    {
        $this->requests();
        $id = $this->router?->getIdFromUrl();

        $this->model->deleteById($id);

        $this->sendResponse([
            'message' => "user with id: $id was deleted successfully",
            'status' => 204,
        ], 204);
    }
}


