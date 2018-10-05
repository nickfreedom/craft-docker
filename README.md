# Setup steps before running docker-compose

* Add dump.sql to pre-load the DB
* Checkout your Craft application into the ```app``` directory.
* Consider adding a teardown script to wrap this CLI call:
    ```
    docker-compose down --volumes --remove-orphans --rmi alls

    docker container list -a
    docker image list
    docker volume list
    ```
    This is a nice way to see that all of the docker components are being removed correctly.
