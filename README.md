# PromoCodes
Promo codes REST API made with Symfony

----

### Stack
* [Symfony framework](https://symfony.com/doc/current/setup.html)
* [Serverless](https://serverless.com/framework/docs/providers/aws/guide/installation/) (for deploying)
* [Docker](https://docs.docker.com/install/) (for database local testing)

### Description
* This is a REST API made to be used as a backend for a promo codes system.
* Currently, the API allow you create, edit, and validate promo codes. You can also register new users.
* The all API is authenticated using JWT token, being only the registered users being allowed to use it.

### Routes description
* **/api/create/{owner}**:
    * **HTTP Method:** POST
    * **Query Parameters:** 
        * discount-percentage (optional: default is 10)
        * expiration-date (optional: default is today + 15 days) 
    * **Description:** Creates a new promo code for the "owner". The "createdBy" is extracted from the authentication token.
    * **Return Values:**
        *  Promo code id
    
       
* **/api/create/{owner}**:
    * **HTTP Method:** POST
    * **Query Parameters:** 
        * discount-percentage (optional: default is 10)
        * expiration-date (optional: default is today + 15 days) 
    * **Description:**
    * **Return Values:**
        * 
        
* **/api/create/{owner}**:
    * **HTTP Method:** POST
    * **Query Parameters:** 
        * discount-percentage (optional: default is 10)
        * expiration-date (optional: default is today + 15 days) 
    * **Description:**
    * **Return Values:**
        *  


| Route                                | HTTP Method | Query parameters                                                                                          | Description                                                                                                                                                                  | Return values                                                                                             |
| :----------------------------------: |------------ | --------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------- |
| /api/create/{owner}                  | POST        | discount-percentage (optional: default is 10)<br>expiration-date (optional: default is today + 15 days)   | Creates a new promo code for the "owner". The "createdBy" is extracted from the authentication token.                                                                        | Promo code id                                                                                             |
| /api/edit/{promoCodeId}              | PATCH       | created-by (optional)<br>discount-percentage (optional)<br>expiration-date (optional)<br>owner (optional) | Edit an existent promo code attributes.                                                                                                                                      | Invalid promo code<br>Success message                                                                     |
| /api/register/user                   | POST        | username (required)<br>password (required)                                                                | Creates a new user with the role "USER". The user you are currently using must have "ADMIN" privileges.                                                                      | Missing parameters<br>User already exists<br>The new user username and roles                              |
| /api/validate/{promoCodeId}/{userId} | GET         |                                                                                                           | Validate if a promo code is valid. The "userId" is the user that is trying to use this promo code (if any), this way we assure that the owner cannot use the own promo code. | Invalid promo code id<br>User cannot use own promo code<br>Promo code already expired<br>Valid promo code |
| /api/login_check                     | POST        | username (required)<br>password (required)                                                                | Creates a new JWT token. This token has a duration of 1 hour.                                                                                                                | Authentication error<br>The new JWT token and a refresh token (1 month duration)                          |
| /api/token/refresh                   | POST        | refresh_token (required)                                                                                  | Returns a fresh JWT token for the same user that was associated to the previous one.                                                                                         | The new JWT token and the same refresh token as before                                                    |
