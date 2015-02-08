mysql-db-optimizer
==========================================

This project was created in 2008 and allows to perform [MySQL OPTIMIZE](http://dev.mysql.com/doc/refman/5.1/en/optimize-table.html) command on a single databse or many databases with different hosts, usernames and passwords. This repository contains two PHP classes. `OptimizeDatabase` is able to optimize single database and `OptimizeDatabases` is able to optimize many databases.

If you are administrator of all databses and every databse is available on one host, you can use the following commands instead of this project:
* `mysqlcheck -o <db_schema_name>` for a single databse
* `mysqlcheck -o --all-databases` for many databases

This project will be useful, when your databses are hosted on different servers or when you are not allowed to use CLI.

Usage & examples
----------------

In order to check, how it works, see `samples` directory. 
* `optimize_single_db.php` file contains example of optimization of single databse.
* `optimize_many_dbs.php` file contains example of optimization of many databses.




