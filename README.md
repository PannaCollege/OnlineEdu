# OnlineEdu

### Tech
- PHP
- Laravel
- PgSQL
- Vuejs
- FialmentPHP
- Livewire
- AlpineJs

## Setup

```bash
    ./refresh.sh
```

> Postman collection already included in root directory.

## Backend Admin Users

- You can login by using below accounts.

```json
    [
        {
            "name": "Panna College",
            "email": "pannacollege@onlineedu.com",
        },
        {
            "name": "Nyan Lynn Htut",
            "email": "nyanlynnhtut@onlineedu.com",
        },
        {
            "name": "Aung Myat Moe",
            "email": "aungmyatmoe@onlineedu.com",
        },
        {
            "name": "Swan Yee Tun",
            "email": "swanyeetun@onlineedu.com",
        },
        {
            "name": "Nyan Lin Htun",
            "email": "nyanlinhtun@onlineedu.com",
        }
        {
            "name": "Myo Zin Kyaw",
            "email": "myozinkyaw@onlineedu.com",
        },
    ]
```

## Third Party Authentication 

### Google 

```php
    # Google Socialite
    GOOGLE_CLIENT_ID=
    GOOGLE_CLIENT_SECRET=
    GOOGLE_FALLBACK_URI=
```

## We'are using following packages

- filament/filament ( Online edu admin panel )
- laravel/socialite ( Third-party authentication )
- laravel/sanctum ( Online edu default authentication )