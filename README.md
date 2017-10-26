How to run
-


1. ```git clone https://github.com/pesovo/cache-example.git```
2. ```cd cache-example```
3. ```docker-compose up -d``` 
(install docker compose: https://github.com/pesovo/2016-docker-workshop/tree/master/03-composed-application)
4. ```docker exec -it php7.1_cache_example bash```
5. ```cd /srv```
6. ```composer update```
7. ```php vendor/bin/phing```
8. ```chmod 777 -R var```


Browser:
- http://localhost:8000/product/5
- http://localhost:8000/counter
