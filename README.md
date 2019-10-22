## LARAVEL E-SHOP WITH BACKEND ADMIN AREA/CMS

### PROJECT DESCRIPTION

Project includes a responsive frontend with product display, shopping cart and ordering functionalities, user account management system, product review system and a backend CMS with a separate administrator login and role based access control system. 

### PROJECT IN DETAIL

##### BACKEND  ADMIN AREA/ CMS:

* Admin login system with access control based on three administrator roles: superadmin, admin and editor
* Content management system with CRUD functionality for products, categories, brands, reviews, orders, discount cards, pages, administrators and site settings
* Complete product management system: manage prices and quantities, upload multiple images, control featured product display. Product filtering and searching functionalities
* Order processing, searching and filtering functionalities
* Soft delete and restore functionalities for products and reviews
* Website page creation functionality with Summernote WYSIWYG editor including page image upload
* Site settings management: update site name, currency, contact info, landing page slider data 

##### FRONTEND WEBSITE

* Shopping cart functionality
* Checkout functionality
* User wishlist functionality for registered users
* Product review functionality for registered users
* User account management system:  user registration and login, user account details management, user order display
* Landing page with featured product display by category
* Products page with filtering and sorting capabilities
* single product page with image slider and product reviews
* Contact form page

### INSTALLATION

* Install composer dependencies
```bash
composer install
```
* Create mysql database and connect it by setting the db credentials in .env file
* Create and seed database tables. Default data is available for all eshop components. 
```bash
php artisan migrate
php artisan db:seed
```
*Note: Default backend administrator is created when seeding database. These credentials can be used to access the admin area.*

* Install Javascript dependencies and compile the project:
```bash
npm install
npm run dev
```
* Configure the mail service provider credentials  in .env file.


### PACKAGES, PLUGINS AND FRAMEWORKS USED IN ADDITION TO LARAVEL

* Javascript
* jQuery
* Axios
* Bootstrap 4 
* Bootstrap Theme [Bootswatch Lux](https://bootswatch.com/lux/) 
* Icon Fonts [Uxwing](https://uxwing.com/free-icon-fonts/)
* Icon Fonts [Font Awesome](https://fontawesome.com/)
* jQuery Plugin [Slick Slider](https://kenwheeler.github.io/slick/) 
* Plugin for Notifications [Toastr](https://github.com/CodeSeven/toastr)
* WYSIWYG Editor [Summernote](https://summernote.org/)
* HTMLPurifier for Laravel [Purifier Plugin](https://github.com/mewebstudio/Purifier) by mewebstudio
* Image Upload Library [Intervention Image](http://image.intervention.io/)
* Shoppingcart Implementation For Laravel Package [Gloudemans Shoppingcart](https://packagist.org/packages/gloudemans/shoppingcart)
