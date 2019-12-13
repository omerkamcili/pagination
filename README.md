# OmerKamcili\Pagination

Calculate and create urls from take, skip and total parameters for pagination.

### Install

Install package with composer

```
composer install omerkamcili\pagination
```

### Example
````
$data = [
    'total' => 359,
    'skip'  => 20,
    'url'   => 'http://www.yourapp.com/currentPage',
];

$pagination = new \OmerKamcili\Pagination\Pagination($data);

print_r($pagination);


foreach($pagination->pages as $page => $url){
    echo "Page $page: $url"; 
}

````

### Parameters

All parameters public, you can access from outside and you can set with construct method

Parameter       | Type          |    Description
--------------- | --------------|-----------------
take            | integer       | Set take parameter
skip            | integer       | Set skip parameter
total           | integer       | Set total parameter
url             | string        | Set url for use about pagination
currentPage     | integer       | Will be calculated auto
totalPages      | integer       | Will be calculated auto
takeLabel       | string        | You can change take name ( for example limit )
skipLabel       | string        | You can change skip name ( for example offset )
nextPage        | string        | Will be created auto ( not implemented )
previousPage    | string        | Will be created auto ( not implemented )
firstPage       | string        | Will be created auto ( not implemented )
lastPage        | string        | Will be created auto ( not implemented )
pages           | array         | Will be created pages, you can iterate the created pages
walkPageNumber  | integer       | Number of pagination item, ( default 3 meanings 11 - 12 - 13 - [14] - 15 - 16 - 17 )

### Contributing

You can create merge request or you can create issue card, there is no rules about this.
