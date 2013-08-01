<?php

namespace MasheryApi;

class Object extends \MasheryApi\Model
{
    /**
     * Object response properties
     * @var array
     */
    protected $properties = array(
        'total_items' => array(
            'type' => 'string',
            'maxlength' => '200'
        ),
        'total_pages' => array(
            'type' => 'string',
            'maxlength' => '200'
        ),
        'items_per_page' => array(
            'type' => 'string',
            'maxlength' => '200'
        ),
        'current_page' => array(
            'type' => 'string',
            'maxlength' => '200'
        ),
        'items' => array(
            'type' => 'array'
        ),
    );

    /**
     * Based on the MQL query, find the objects + data requested
     *
     * @param array $args Query arguments (arg[0] should be MQL)
     * @return  \MasheryApi\Object Object instance
     */
    public function find($args)
    {
        if (!isset($args[0])) {
            throw new \InvalidArgumentException('Invalid query defined');
        }

        $query = $args[0];
        $data = json_encode(array(
            'method' => 'object.query',
            'params' => array($query),
            'id' => 1
        ));

        try {
            $result = $this->getRequest()->send($data);
            if ($result->result !== null) {
                $this->values((array)$result->result);
            }
            return $this;
        } catch (\Exception $e) {
            throw new \Exception('There was an error executing the query: '.$e->getMessage());
        }
    }
}