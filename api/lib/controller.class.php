<?php

class Controller {

    protected $data;
    protected $model;
    protected $params;
    protected $request = [];

    public function __construct($data = []) {
        $this->data = $data;
        $this->params = App::getRouter()->getParams();
    }

    public function requests()
    {
       return $this->filterRequestData();
    }

    public function initHeaders($method)
    {
        header("Content-type: application/json; charset=utf-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: $method");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function filterRequestData()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ('PUT' === $method || 'PATCH' === $method) {
            $this->initHeaders($method);
            $putFp = fopen('php://input', 'r');
            $putData = '';
            while ($data = fread($putFp, 1024))
                $putData .= $data;
            fclose($putFp);
            $oneline = preg_replace('/\s+/', '', substr($putData, 0, strlen($putData)));

            if (str_contains($oneline, 'name=')) {
                $array = explode('name=', $oneline);
                $dataPrepare = [];
                for ($i = 1; $i < count($array); $i++) {
                    $dataPrepare[] = strstr($array[$i], '-', true);
                }
            }

            $dataFields = [];
            foreach ($dataPrepare as $split) {
                $dataFields[] = explode(':', substr(str_replace('"', ':', $split), 1, strlen($split)));
            }

            $data = [];
            foreach ($dataFields as $dataField) {
                $fieldName = $dataField[0];
                $fieldValue = $dataField[1];
                if (is_numeric($fieldValue)) {
                    $data[] = [
                      'field' => $fieldName,
                      'value' => $fieldValue
                    ];
                }

                else if (is_string($fieldValue)) {
                    $data[] = [
                        'field' => $fieldName,
                        'value' => $fieldValue
                    ];
                }
            }
            $this->request = $data;
        }
        elseif ('GET' === $method) {
            $this->initHeaders($method);
            $this->request = $_REQUEST;
        }
        elseif ('POST' === $method) {
            $this->initHeaders($method);
            $this->request = $_REQUEST;
        }
        elseif ('DELETE' === $method) {
            $this->initHeaders($method);
            $this->request = $_REQUEST;

        }
        return $this->getRequest();
    }

    public function sendResponse(array $data = [], $httpStatusCode = 200) {
        http_response_code($httpStatusCode);
        echo json_encode($data);
        exit();
    }

    public function getData() {
        return $this->data;
    }

    public function getModel() {
        return $this->model;
    }

    public function getParams() {
        return $this->params;
    }

    public function getRequest() {
        return $this->request;
    }
}
