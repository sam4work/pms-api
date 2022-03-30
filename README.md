
# Project Title

This simple api that support Sanctum Authentication via Laravel Breeze.

## Acknowledgements

- [Awesome Readme Templates](https://awesomeopensource.com/project/elangosundar/awesome-README-templates)
- [Awesome README](https://github.com/matiassingers/awesome-readme)
- [How to write a Good readme](https://bulldogjob.com/news/449-how-to-write-a-good-readme-for-your-github-project)
- [Laravel Docs](https://laravel.com/docs/9.x)
## Authors
- [@sam4work](https://github.com/sam4work)


## Documentation & Reference

Laravel [Documentation](https://laravel.com/docs/9.x)


## Tech Stack

**Server:** Laravel v8+, MySQL v8.0+


## Deployment

To deploy this project run


```bash
  git clone https://github.com/sam4work/pms-api.git
```

```bash
  cd pms-api
```

```bash
  composer install
```

```bash
  php atisan breeze:install api
```

```bash
  php artisan migrate --seed 
```

Open .env File and add the following. Handles cors for your client request
```
  FRONTEND_URL=http://{domain}:{port} //localhost:5555
```

## API Reference

#### Create customer

```http
  POST /api/customers/store
```

| Request | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `first_name`| `string` | **Required**. Customer First name|
| `last_name`| `string` | **Required**. Customer Second Name|
| `isp_code`| `digits` | **Required**. Service Provider Code|
| `phone_number`| `digits` | **Required**. Seven Digit phone number|
| `ghana_card_no`| `digits` | **Required**. 6 digit unique number|
| `owner`| `string` | **Required**. If Customer Owners the Phone Number|
| `service_type`| `string` | **Required**. ENUM POSTPAID or PREPAID|



#### Get all customers

```http
  GET /api/customers
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `search(optional)` |  `string`| Search For customers |

#### Get customer

```http
  GET /api/customers/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of customer to fetch |




#### Delete customer

```http
  Delete /api/customers/${id}/destroy
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`| `int` | **Required**. Customer Unique ID |



#### Update customer (?)

```http
  PATCH /api/customers/${id}/update
```

| Request | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `first_name`| `string` | **Required**. Customer First name|
| `last_name`| `string` | **Required**. Customer Second Name|
| `isp_code`| `digits` | **Required**. Service Provider Code|
| `phone_number`| `digits` | **Required**. Seven Digit phone number|
| `ghana_card_no`| `digits` | **Required**. 6 digit unique number|
| `owner`| `string` | **Required**. If Customer Owners the Phone Number|


## Know Issues
Update Customer Records
## License

[MIT](https://choosealicense.com/licenses/mit/)

