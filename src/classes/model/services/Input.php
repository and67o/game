<?php


namespace Router\Models\Services;


class Input
{
 
    const METHOD_REQUEST_POST = 'POST';
    const METHOD_REQUEST_GET = 'GET';
    /**
     * @var array
     */
    public $data;
    /**
     * @var string
     */
    public $type;

    /**
     * @param string $data
     * @param string $type
     */
    public function setInputParam($data = '', $type = self::METHOD_REQUEST_POST) {
        $this->setData($data);
        $this->setType($type);

        $this->jsonParams();
    }
    
    /**
     * @param $data
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    
    /**
     * @param string $type
     * @return void
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }
    
    /**
     * @return string
     */
    public function getType(): string
    {
        return (string)$this->type;
    }
    
    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * Какой метод запроса
     * @return bool
     */
    public function checkRequestMethod()
    {
        switch ($this->getType()) {
            case self::METHOD_REQUEST_POST:
                return $_SERVER['REQUEST_METHOD'] === self::METHOD_REQUEST_POST;
                break;
            case self::METHOD_REQUEST_GET:
                return !$_GET ? true : false;
                break;
            default:
                return false;
                break;
        }
    }
    
    /**
     * @param string $key
     * @param string $dataType
     * @return mixed|string
     * @phpunit
     */
    public function get(string $key, string $dataType = '')
    {
        $data = $this->getData();
        $param =  isset($data[$key])
            ? $data[$key]
            : '';
        
        return $dataType
            ? $this->_dataTypes($dataType, $param)
            : $param;
    }
    
    /**
     * Вернуть данные в требуемом виде
     * @param $dataType
     * @param $param
     * @return array|bool|float|int|string
     */
    private function _dataTypes($dataType, $param) {
        //TODO Добавить в тесты преобразование типов
        switch ($dataType) {
            case 'string': return (string) $param;
            case 'int':    return (int) $param;
            case 'bool':   return (bool) $param;
            case 'float':  return (float) $param;
            case 'array':  return (array) $param;
        }
        return $param;
    }
    
    /**
     * Метод преобразования строки массив
     * @phpunit
     * @return array|int
     */
    public function jsonParams()
    {
        $data = $this->getData();
        
        if (is_array($data)) {
            return $data;
        }
        
        return json_decode(
                (string)$data,
                true,
                JSON_OBJECT_AS_ARRAY | JSON_BIGINT_AS_STRING | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK
            ) ?? [];
        
    }
}
