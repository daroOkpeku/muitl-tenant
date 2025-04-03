Accessing the Admin Section
To access the admin section of the application, run:


php artisan serve --port=9000
Then, open the admin web route in your browser.

Creating a Multi-Tenant Domain
To create a new multi-tenant domain, use the API to add it to the database:


http://127.0.0.1:9000/create_tenant
Accessing the User API
To access the user API, run:


php artisan serve
Then, use the following API endpoints:

Register: http://127.0.0.1:8000/api/register

Login: http://127.0.0.1:8000/api/login

Blog List: http://127.0.0.1:8000/api/blog_list

Middleware
Middleware is used to handle multi-tenancy for each domain:

AdminMiddleware – For the admin panel

IdentifyTenant – For identifying the user’s tenant

Gates and Policies
Gates and policies are implemented to handle authorization for the admin section of the application.

Database File
The database file has been added to the root folder.