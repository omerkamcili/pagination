<?php

namespace OmerKamcili\Pagination;

use Exception;

/**
 * Class Pagination
 */
class Pagination
{

    /**
     * @var int
     */
    public $take = 10;

    /**
     * @var int
     */
    public $skip = 0;

    /**
     * @var int
     */
    public $total;

    /**
     * @var int
     */
    public $currentPage;

    /**
     * @var
     */
    public $totalPages;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $takeLabel = 'take';

    /**
     * @var string
     */
    public $skipLabel = 'skip';

    /**
     * @var
     */
    public $nextPage;

    /**
     * @var
     */
    public $previousPage;

    /**
     * @var
     */
    public $firstPage;

    /**
     * @var
     */
    public $lastPage;

    /**
     * @var array
     */
    public $pages = [];

    /**
     * @var int
     */
    public $walkPageNumber = 3;

    /**
     * Pagination constructor.
     *
     * @param array $properties
     *
     * @throws Exception
     */
    public function __construct(array $properties = [])
    {

        foreach ($properties as $key => $foo) {

            if (property_exists($this, $key)) {

                $this->{$key} = $foo;

            } else {

                throw new Exception("There is no $key property");
            }
        }

        if ($this->take < 1) {

            throw new Exception('Take parameter should be greater then one');

        }

        $this->calculate();

    }

    /**
     * Calculate pagination
     */
    public function calculate()
    {

        $this->totalPages  = ceil($this->total / $this->take);
        $this->currentPage = ($this->skip / $this->take) + 1;
        $params            = [];

        if ($this->url) {

            $explodedUrl = explode('?', $this->url);
            $this->url   = $explodedUrl[0];

            if (count($explodedUrl) > 1) {

                $explodedParams = explode('&', $explodedUrl[1]);

                foreach ($explodedParams as $explodedParam) {

                    $param = explode('=', $explodedParam);

                    $key   = $param[0];
                    $value = $param[1];

                    if ($key != $this->takeLabel && $key != $this->skipLabel) {

                        array_push($params, ['key' => $key, 'value' => $value]);

                    }

                }

            }

        }

        if ($this->currentPage > 1) {

            for ($i = ($this->currentPage - 1); $i > $this->currentPage - ($this->walkPageNumber + 1); $i--) {

                if ($i == 0) {

                    break;

                }

                $pageNumber               = intval(ceil($i));
                $data                     = array_merge($params, $this->createTakeAndSkipParameters($pageNumber));
                $this->pages[$pageNumber] = $this->makeUrlWithParams($data);

            }

        }

        $data                            = array_merge($params, $this->createTakeAndSkipParameters($this->currentPage));
        $this->pages[$this->currentPage] = $this->makeUrlWithParams($data);

        if ($this->currentPage < $this->totalPages) {

            for ($i = ($this->currentPage + 1); $i < $this->currentPage + ($this->walkPageNumber + 1); $i++) {

                if ($i == $this->totalPages) {

                    break;

                }

                $pageNumber = intval(ceil($i));

                $this->pages[$pageNumber] = $this->makeUrlWithParams(array_merge($params, $this->createTakeAndSkipParameters($pageNumber)));

            }

        }

        ksort($this->pages);


        // TODO: Calculate nextPage, previousPage, firstPage and lastPage
    }

    /**
     * @param $params
     *
     * @return string
     */
    private function mergeParams($params)
    {

        $convertedParams = [];

        foreach ($params as $param) {

            array_push($convertedParams, $param['key'] . '=' . $param['value']);

        }

        return implode('&', $convertedParams);

    }

    /**
     * @param $params
     *
     * @return string
     */
    private function makeUrlWithParams($params)
    {

        return $this->url . '?' . $this->mergeParams($params);

    }

    /**
     * @param $page
     *
     * @return array
     */
    private function createTakeAndSkipParameters($page)
    {

        if ($page == 1) {

            return [
                ['key' => $this->takeLabel, 'value' => $this->take],
                ['key' => $this->skipLabel, 'value' => 0],
            ];

        }

        return [
            ['key' => $this->takeLabel, 'value' => $this->take],
            ['key' => $this->skipLabel, 'value' => ($this->take * ($page - 1))],
        ];

    }

}