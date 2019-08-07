# PromoCodes
Promo codes REST API made with Symfony

----

## Stack
* [Symfony framework](https://symfony.com/doc/current/setup.html)
* [Serverless](https://serverless.com/framework/docs/providers/aws/guide/installation/) (for deploying)
* [Docker](https://docs.docker.com/install/) (for database local testing)

## Description
* This is a REST API made to be used as a backend for a promo codes system.
* Currently, the API allow you create, edit, and validate promo codes. You can also register new users.
* The all API is authenticated using JWT token, being only the registered users being allowed to use it.

## Routes details
* **/api/create/{owner}**:
    * **HTTP Method:** 
        * POST
    * **Query Parameters:** 
        * discount-percentage (optional: default is 10)
        * expiration-date (optional: default is today + 15 days) 
    * **Description:** 
        * Creates a new promo code for the "owner". The "createdBy" is extracted from the authentication token.
    * **Return Values:**
        * Promo code id
    
       
* **/api/edit/{promoCodeId}**:
    * **HTTP Method:** 
        * PATCH
    * **Query Parameters:** 
        * created-by (optional)
        * discount-percentage (optional)
        * expiration-date (optional)
        * owner (optional)
    * **Description:** 
        * Edit an existent promo code attributes.
    * **Return Values:**
        * Invalid promo code<br>Success message
       
        
* **/api/register/user**:
    * **HTTP Method:** 
        * POST
    * **Query Parameters:** 
        * username (required)
        * password (required)
    * **Description:** 
        * Creates a new user with the role "USER". The user you are currently using must have "ADMIN" privileges.
    * **Return Values:**
        * Missing parameters
        * User already exists
        * The new user username and roles
        
      
        
* **/api/validate/{promoCodeId}/{userId}**:
    * **HTTP Method:** 
        * GET
    * **Query Parameters:** 
    * **Description:** 
        * Validate if a promo code is valid. The "userId" is the user that is trying to use this promo code (if any), this way we assure that the owner cannot use the own promo code.
    * **Return Values:**
        * Invalid promo code id
        * User cannot use own promo code
        * Promo code already expired
        * Valid promo code

        
* **/api/login_check**:
    * **HTTP Method:** 
        * POST
    * **Query Parameters:** 
        * username (required)
        * password (required)
    * **Description:** 
        * Validate if a promo code is valid. The "userId" is the user that is trying to use this promo code (if any), this way we assure that the owner cannot use the own promo code.
    * **Return Values:**
        * Authentication error
        * The new JWT token and a refresh token (1 month duration)
        

* **/api/token/refresh**:
    * **HTTP Method:** 
        * POST
    * **Query Parameters:** 
        * refresh_token (required)
    * **Description:** 
        * Returns a fresh JWT token for the same user that was associated to the previous one.
    * **Return Values:**
        * The new JWT token and the same refresh token as before                                                   |

## TODO (promo code attributes):
* Edited by
* Last used at
* Number of uses
* Active (acts like a cache for the validation action)

