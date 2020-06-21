# Forumation
An extremely easy to use, fully featured forum software with built-in control panel and data management.
(Demo website coming soon)

## Prerequisites
- Forumation clone
- Node.js installation
- MariaDB installation
- PHP installation
- Composer installation
- Web server of your choice (Nginx, Apache HTTP, etc)

## Install Guide
- Configure your web server to serve Forumation clone
- Copy the 'example.env' file to '.env' in the Forumation clone.
- Run 'composer install' and 'php artisan key:generate' on your CLI (or simply hit install_dependencies_win.bat on Windows).
- Run 'npm install'
- Refer to your .env file as you setup your MariaDB server, make sure the database values match with yours (you must create database 'Forumation' or whatever you have configured the database name to be).
- Your installation should be ready to serve, start your web server. 


Currently there is an installer only for Windows [Forumation-Installer](https://github.com/ThePadna/Forumation-Installer) which runs on NodeJS, you may use this instead of the above guide.
