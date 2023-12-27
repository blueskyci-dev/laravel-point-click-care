## PointClickCare wrapper for Laravel

# WARNING - WIP [Paginated results not finished]

This composer package makes connecting and working with the PointClickCare API easier and more fluent within laravel.

### Installation
~~~bash
composer require blueskyci/laravel-point-click-care
~~~

Publish the vendor files so that you can inherit configurations, migrations, and setup views.

~~~bash
php artisan vendor:publish --provider="Blueskyci\PointClickCare\PointClickCareServiceProvider"
~~~

Add the secrets to your .env file

~~~bash
POINTCLICKCARE_CLIENT_ID=
POINTCLICKCARE_CLIENT_SECRET=
POINTCLICKCARE_DEFAULT_ORG_UUID=
~~~


### Usage
~~~php
// Initiate a connection using client credentials
$pcc = PointClickCare::organization(); // Use the default org from .env
$pcc = PointClickCare::organization($orgUuid); // Override the org UUID

// returns a collection of facilities
$pcc->facilities()->all();
~~~

### Available Resources 

- [x] Facilities
    - Find
    - List
- [x] Patients
    - Find
    - List

Testing
~~~bash
composer test
~~~

