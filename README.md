# Media Rental API

API REST desarrollada en **Laravel 12** para la gestión de medios publicitarios, clientes y reservas, como parte de una prueba técnica. El sistema permite administrar medios, clientes, reservas, verificar disponibilidad y calcular precios automáticamente.

---

## Requisitos

Los requisitos primordiales para la ejecucion de este proyecto se listan a continuación:

* PHP **>= 8.2**
* Composer
* MySQL
* Node.js (ya que cuenta con desarrollo frontend)
* Git

---

## Instalación

1. Clonar el repositorio:

```bash
git https://github.com/SrgP2003/media-rental-api
cd media-rental-api
```

2. Instalar dependencias de PHP:

```bash
composer install
```

3. Copiar el archivo de entorno:

```bash
cp .env.example .env
```

4. Generar la key de la aplicación:

```bash
php artisan key:generate
```

---

## Variables de entorno

La configuración de las variables de entorno se ubicarán en el archivo `.env`. Estas serán vitales para los datos de conexión a la base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=media_rental
DB_USERNAME=root
DB_PASSWORD=root
```
---

## Migraciones y Seeders

Ejecutar migraciones y cargar datos de prueba:

```bash
php artisan migrate:refresh --seed
```

Esto creará las tablas y las llenará en la base de datos con:

* Medios publicitarios
* Clientes
* Reservas de ejemplo

---

## Ejecución del proyecto

Levantar el servidor de desarrollo:

```bash
php artisan serve
```

La API estará disponible en:

```
http://localhost:8000
```

---

## Endpoints principales

### Media

* `GET /api/media` (paginado + filtros)
* `POST /api/media`
* `GET /api/media/{id}`
* `PUT /api/media/{id}`
* `DELETE /api/media/{id}` (desactiva el medio)
* `GET /api/media/{id}/availability?starts_at=YYYY-MM-DD&ends_at=YYYY-MM-DD`

### Customers

* `GET /api/customers`
* `POST /api/customers`
* `GET /api/customers/{id}`

### Bookings

* `GET /api/bookings` (paginado + filtros)
* `POST /api/bookings`
* `GET /api/bookings/{id}`
* `PATCH /api/bookings/{id}/status`

---

## Decisiones técnicas

* **Laravel 12**: Se utilizó la versión más reciente para aprovechar mejoras en routing, Form Requests y Resources.
* **API Resources**: Para estandarizar las respuestas JSON y facilitar el consumo desde frontend (Nuxt.js).
* **Form Requests**: Toda la validación se encapsula en Requests dedicados para mantener controladores limpios.
* **Soft delete lógico**: En Media, se optó por desactivar (`status = inactive`) en lugar de eliminar registros.
* **Cálculo de precios centralizado**: La lógica de cálculo de precios se implementó en el modelo `Booking`.
* **Disponibilidad de medios**: Se valida el solapamiento de fechas a nivel de base de datos para evitar reservas inválidas.
* **Pensado para frontend**: La estructura de respuestas está diseñada para integrarse fácilmente con Nuxt.js.

---

## Estado del proyecto

✔ Migraciones
✔ Seeders
✔ Modelos
✔ Controladores API
✔ Form Requests
✔ API Resources
✔ Endpoint de disponibilidad
✔ Listo para integración frontend

---

📌 **Autor:** Sergio Alejandro Arévalo Palacios
