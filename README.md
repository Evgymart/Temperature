## Startup

The application is easy to stat, just run:
```
    docker compose up
```

To apply migrations. You can check them out in the 'migrations' folder:
```
docker ps
docker exec -it  <container_name> bash -c "./vendor/bin/doctrine-migrations migrate"
```

Test queries:

Push
```
curl --location 'http://127.0.0.1:8080/api/push' \
--header 'Content-Type: application/json' \
--data '{
    "reading": {
        "sensor_uuid": "222ynik",
        "temperature": 6.84
    }
}'
```

Read
```
curl --location 'http://127.0.0.1:8080/sensor/read/192.168.2.77'
```

Average
```
curl --location 'http://127.0.0.1:8080/api/average?days=2'
```

Sensor average
```
curl --location 'http://127.0.0.1:8080/api/sensor_average?sensor_uuid=222ynik'
```

## Things that can be improved:

This is not a complete project, there is a couple of things that need more work, listed in order of priority:

1. Unit and integration tests
2. A logging system
3. Rewriting the router or using a third party router, current implementation is not perfect.
4. A better validation system with error codes and error messages
5. ORM.
6. A better way to handle global Application entity.
7. XDebug
