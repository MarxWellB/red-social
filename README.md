# FansRoad – Backend (Laravel)

API en **Laravel 10+ / PHP 8.1+** para gestionar usuarios, eventos y tickets de FansRoad.  
Incluye estructura modular (routes/controllers/services), CORS y documentación por **OpenAPI/Swagger**.

![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?logo=php)
![Laravel](https://img.shields.io/badge/Laravel-10+-FF2D20?logo=laravel)
![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)

---

## ✨ Funcionalidades (MVP)
- Auth (placeholder, listo para Sanctum/JWT)
- CRUD base de **eventos** (esqueleto)
- Estructura para **tickets** (WIP)
- **CORS** habilitado para frontends (React/Vue/etc.)
- **Swagger UI** en `/docs` (si existe `src/docs/openapi.json`)

---

## 🚀 Stack
- **Laravel 10+**, **PHP 8.1+**
- Base de datos: MySQL/PostgreSQL (configurable)
- Swagger: `swagger-ui-express` vía bridge PHP–static (o servidor simple)
- Testing: PHPUnit (opcional)

---

## 📦 Requisitos
- PHP 8.1+
- Composer
- MySQL/PostgreSQL
- Opcional: Node para levantar Swagger estático (si lo usas así)

---

## 🔧 Configuración rápida

```bash
git clone https://github.com/TU_USUARIO/fansroad-backend.git
cd fansroad-backend
composer install

cp .env.example .env
php artisan key:generate

# Configura la DB en .env
php artisan migrate --seed  # opcional: agrega tus seeders

php artisan serve  # http://127.0.0.1:8000
