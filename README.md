# Library web app

![Alt text](/public/images/APP1.gif)


## Description:

This web app is imagined as app used in libraries by both users and librarians. It enables quick and efficient book trade. This project was made as an excercise for Laravel Framework programming environment.

There are three main roles that can use this app:

### Guests:
- search the whole catalogue (by author or title)
- see informations about books, authors and copies (avaliability, name, biography, description..)

### Registered users:
- search the whole catalogue (by author or title)
- see informations about books, authors and copies (avaliability, name, biography, description..)
- borrow copy of desired book (if avaliable, max 3 borrowed books)
- see borrowed books on "My books" page

### Administrator (librarian):
- add, edit and delete books, copies and authors (maintain the catalogue)
- see all the users and borrowed books (with time of rent)
- return the book from user
- see all activity logs


## Instalation and usage

### Database
- postgreSQL (v 15.0)
- To use postgreSQL, make sure you install it, setup a database and then add your db credentials(database, username and password) to the .env.example file and rename it to .env
- To use something different, open up config/Database.php and change the default driver.

### Migrations
To create all the nessesary tables and columns, run the following
```
php artisan migrate
```

### Seeding The Database
To add the dummy books, authors, copies with three users, run the following
```
php artisan db:seed
```
Credentials for dummy users:

Admin: 
- email: librarian@test.com
- pass: 123456

User1:
- email: user1@test.com
- pass: 123456

User2:
- email: user2@test.com
- pass: 123456

### File Uploading
When uploading files, they go to "storage/app/public". Create a symlink with the following command to make them publicly accessible
```
php artisan storage:link
```

### Running Then App
Upload the files to your document root, Valet folder or run 
```
php artisan serve
```

## License

[MIT license](https://opensource.org/licenses/MIT).
