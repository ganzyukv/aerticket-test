# Тестовое задание AERTiCKET

Реализовать API и интерфейс к нему.

Интерфейс оформить в виде небольшого веб-приложения из одной страницы
(дизайн не важен).

С помощью этого приложения и API можно осуществлять поиск перелётов между
двумя аэропортами на конкретную дату.

Входные данные от пользователя:
- аэропорт вылета
- аэропорт назначения
- дата перелета

**Результатом поиска** является список рейсов на выбранную дату между указанными
аэропортами.

По каждому рейсу известно:

- перевозчик
- номер рейса
- время вылета (местное время)
- время прилета (местное время)
- длительность перелёта в минутах

Результаты вывести в порядке времени вылета.

Для поиска реализовать серверную и клиентскую часть API из одного метода:
- search

Справочник поддерживаемых перевозчиков и аэропортов - придумать
самостоятельно.

Реализовать базовые сообщения об ошибках:

- неверный запрос
- неверно указан аэропорт
- неверно указана дата вылета
- ничего не найдено

Предусмотреть **Basic авторизацию**.

### Пример запроса search к API в формате JSON:
```json
  {
    "searchQuery": {
        "departureAirport": "KBP",
        "arrivalAirport": "BUD",
        "departureDate": "2018-07-01"
    }
  }
```

### Пример ответа на запрос search к API в формате JSON:
```json
  {
    "searchQuery": {
        "departureAirport": "IEV",
        "arrivalAirport": "BUD",
        "departureDate": "2018-07-01"
    },
    "searchResults": [
        {
            "transporter": {
                "code": "W6",
                "name": "WizzAir"
            },
            "flightNumber": "W64556",
            "departureAirport": "IEV",
            "arrivalAirport": "BUD",
            "departureDateTime": "2018-07-01 09:30",
            "arrivalDateTime": "2018-07-01 12:10",
            "duration": 100
        },
        {
            "transporter": {
                "code": "PS",
                "name": "UkraineInternational"
            },
            "flightNumber": "PS1234",
            "departureAirport": "IEV",
            "arrivalAirport": "BUD",
            "departureDateTime": "2018-07-01 10:00",
            "arrivalDateTime": "2018-07-01 12:35",
            "duration": 95
        },
        {
            "transporter": {
                "code": "W6",
                "name": "WizzAir"
            },
            "flightNumber": "W64558",
            "departureAirport": "IEV",
            "arrivalAirport": "BUD",
            "departureDateTime": "2018-07-01 18:00",
            "arrivalDateTime": "2018-07-01 20:30",
            "duration": 90
        }
    ]
  }
```

##  Для запуска необходимо:
### 1. Склонировать проект 
```shell script
  git clone git@github.com:ganzyukv/aerticket-test.git
  cd aerticket-test
```
### 2. Инициализация Docker окружения
```shell script
  make init
``` 

### 3. По окончанию инициализации 

Для авторизации исползуется Basic Auth:

**Login:** test

**Password:** qwerty

Метод GET [http://127.0.0.1:8080/search](http://127.0.0.1:8080/search) - все доступные рейсы.
 
Метод POST [http://127.0.0.1:8080/search](http://127.0.0.1:8080/search) - поисковый результат для запроса вида:
```json
    {
        "searchQuery":{
            "departureAirport": "TSS",
            "arrivalAirport": "WKK",
            "departureDate": "2020-03-12"
        }
    }
``` 
