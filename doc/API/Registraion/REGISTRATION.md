# Регистрация нового пользователя

Запрос:
```
POST /api/register
Content-Type: application/json
``` 
Параметры запроса:
```
{
    "username": "string",
    "email": "string",
    "password": "string"
}
```
Обязательные поля 
* ```username``` (string);
   * длина 3-180 символов
   * пример "johndoe"
* ```email``` (string);
   * должен быть в валидном формате
   * пример "johndoe@example.com"
* ```password``` (string);
    * минимальная длина 5 символов
    * должен содерать минимум 1 букву
    * должен содержать минимум 1 цифру
    * пример "P1ssw0rd"

## Варианты ответа:
### Стандартный шаблон ответа - [пример](../../Example/RESPONSE_EXAMPLE.md)

### Успешная регистрация
```
HTTP/1.1 201 Created
{
    "status": "success",
    "message": "Пользователь {{ username }} успешно зарегистрирован",
    "data": {
        "userId": ID зарегистрированного пользователя
    }
}
```

### Ошибка валидации
```
HTTP/1.1 400 Bad Request
{
    "status": "error",
    "message": "Ошибка валидации",
    "data": {
        "username": "Описание ошибки валидации",
        "email": "Описание ошибки валидации",
        "password": "Описание ошибки валидации"
    }
}
```
### Прочие ошибки
```
HTTP/1.1 x00 Error Code
{
    "status": "error",
    "message": "Описание ошибки"
}
```

[назад](../API.md)