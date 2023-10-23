## About This Basic Blogging Platform

This is a simple blog post Laravel application with minimum php version 8.1

## Available Features
- Latest blog post as home page
- Paging posts (10 per page)
- Search blog post via "title"
- If full test search applied on mysql columns, the code to search via FullText search is written as comments
- User Authentication features are built using Laravel bootsrap UI libraries like login, register, request for password reset, request for password reset
- A minimulist user blog post administraiton panel is available via 'My Blog Posts' to list,add,edit,delete blog posts authored by the logged in user.
- Blog post can have optional image upload
- Blog post image uploaded is resied to 250x250 thumbnail
- On modifying a blog post, if any previous upload image file exists, that will be removed to save disk space.
- A blog can be only be deleted via the original Author, and he/she has to be logged in.
- When a blog post is deleted, if any uploaded image file exist, that will be removed also.
- Comments can be added on a blog post if a user is logged in.
- Only Author of the comment can delete his/her own comment the blog post


Please do copy the .env.example to .env file, and set it up for your settings:

## Setup
After the .env file settings for databas has been set. Please use the following commands:

#### PHP Composer dependencies
- composer install
- php artisan migrate
- php db:seed
- php artisan storage:link
(To create the symbolic link of storage folder to public folder)

#### Javascript frontend dependencies (using laravel-vite-plugin)
- npm install
- npm run build


## Checking schedule

- php artisan schedule:list

## Executing the new post email comand

- php artisan app:send-new-blog-posts-by-email

## Runnging Feature Tests

- php artisan test

## License

The project is open-source.
