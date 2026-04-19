# SUOEM - Sistema de Gestión Sindical

Sistema de administración y gestión para el **Sindicato Unión Obreros y Empleados Municipales (SUOEM)** de San Juan, Argentina. Permite gestionar órdenes de compra/descuento de afiliados contra proveedores (farmacias, comercios y profesionales médicos), movimientos de farmacia y reintegros.

---

## Stack tecnológico

| Componente | Versión |
|---|---|
| PHP | 8.4 |
| Laravel | 12 |
| Filament | 5.5.x |
| MySQL | 8.0 |
| Redis | 7 |
| Nginx | 1.25 |
| Spatie Laravel Permission | 7.x |
| Laravel Excel (maatwebsite) | 3.x |

---

## Entorno de desarrollo

El proyecto corre en Docker. Todos los comandos `artisan` y `composer` deben ejecutarse **dentro del contenedor**:

```bash
docker exec suoem_app php artisan <comando>
docker exec suoem_app composer <comando>
```

### Levantar el entorno

```bash
cd D:/desarrollo/docker/suoem/suoem_sistema_gestion
docker compose up -d
```

### Contenedores

| Contenedor | Descripción | Puerto |
|---|---|---|
| `suoem_app` | PHP 8.4-FPM | — |
| `suoem_nginx` | Nginx (web server) | 8080 |
| `suoem_mysql` | MySQL 8.0 | 3306 |
| `suoem_redis` | Redis 7 | 6379 |

### Accesos

| Recurso | URL / Credencial |
|---|---|
| Panel Filament | http://localhost:8080/admin |
| Usuario admin | admin@suoem.com / admin123 |
| MySQL host (externo) | localhost:3306 |
| MySQL database | suoem |
| MySQL user | suoem / suoem |

### Nota sobre volúmenes

El directorio `vendor/` usa un **volumen Docker nombrado** (`suoem_vendor`) en lugar de bind mount. Esto evita el límite de MAX_PATH de Windows con los archivos de idioma de Filament. Si se reinstalan dependencias, hacerlo siempre desde dentro del contenedor con el timeout extendido:

```bash
docker exec --env COMPOSER_PROCESS_TIMEOUT=600 suoem_app composer install
```

---

## Estructura del proyecto

```
app/
├── Filament/
│   └── Resources/
│       ├── Afiliados/
│       │   ├── AfiliadoResource.php       # Grupo nav: "Afiliados"
│       │   ├── Pages/
│       │   │   ├── ListAfiliados.php
│       │   │   ├── CreateAfiliado.php
│       │   │   └── EditAfiliado.php
│       │   ├── Schemas/
│       │   │   └── AfiliadoForm.php       # Formulario con secciones
│       │   └── Tables/
│       │       └── AfiliadosTable.php     # Tabla con filtros
│       ├── Zonas/
│       │   ├── ZonaResource.php           # Grupo nav: "Configuración"
│       │   ├── Pages/...
│       │   ├── Schemas/ZonaForm.php
│       │   └── Tables/ZonasTable.php
│       └── Condicions/
│           ├── CondicionResource.php      # Grupo nav: "Configuración"
│           ├── Pages/...
│           ├── Schemas/CondicionForm.php
│           └── Tables/CondicionsTable.php
├── Models/
│   ├── User.php          # implements FilamentUser, HasRoles
│   ├── Afiliado.php
│   ├── Zona.php
│   └── Condicion.php
└── Providers/
    └── Filament/
        └── AdminPanelProvider.php   # Panel "admin", brandName SUOEM, locale es

database/
├── migrations/
│   ├── ..._create_users_table.php
│   ├── ..._create_permission_tables.php   # Spatie
│   ├── ..._create_zonas_table.php
│   ├── ..._create_condiciones_table.php
│   └── ..._create_afiliados_table.php
└── seeders/
    └── ZonasCondicionesSeeder.php   # 14 zonas + 4 condiciones precargadas

lang/vendor/
├── filament/es/            # Traducciones Filament core
├── filament-actions/es/    # Traducciones acciones (crear, editar, borrar)
├── filament-tables/es/     # Traducciones tablas
├── filament-forms/es/      # Traducciones formularios
└── filament-notifications/es/
```

---

## Base de datos

### Tablas implementadas

```sql
zonas          (id, nombre, activo, timestamps)
condiciones    (id, nombre, activo, timestamps)
afiliados      (id, legajo, apellido, nombre, cuil, zona_id, condicion_id, cbu, telefono, activo, timestamps)
```

### Tablas pendientes (a implementar)

```sql
-- Módulo Proveedores
tipo_proveedores   (id, nombre, activo)
proveedores        (id, codigo, nombre, tipo_id, telefono, activo)

-- Módulo Órdenes de Compra
codigos_operacion  (id, codigo, descripcion, activo)
ordenes            (id, nro_orden, proveedor_id, cod_operacion_id, afiliado_id,
                    monto_total, monto_cuota, nro_cuotas, mes_primer_descuento,
                    dia_pago, mes_liquidacion, observacion, timestamps)
cuotas_orden       (id, orden_id, nro_cuota, anio_pago, mes_pago, importe,
                    estado, observacion)

-- Módulo Farmacia
movimientos_farmacia (id, proveedor_id, mes_rendido, importe_presentado,
                      porcentaje_reintegro, importe_reintegro,
                      importe_orden_compra, observacion, fecha_registro)

-- Módulo Reintegros
tipos_reintegro    (id, nombre, activo)
reintegros         (id, numero, fecha, afiliado_id, tipo_reintegro_id,
                    importe, cbu, fecha_transferencia, telefono,
                    observacion, estado)
```

---

## Módulos del sistema

### Implementados
- **Configuración:** ABM de Zonas y Condiciones
- **Afiliados:** CRUD completo con búsqueda, filtros por zona/condición/estado

### Pendientes
- **Proveedores:** Farmacias, Comercios, Profesionales Médicos
- **Códigos de Operación:** Tabla de referencia
- **Órdenes de Compra/Descuento:** Registro y seguimiento de cuotas
- **Módulo Farmacia:** Movimientos mensuales con porcentaje de reintegro
- **Módulo Reintegros:** Registro con estados y transferencias
- **Usuarios y Permisos:** Roles con Spatie
- **Dashboard:** Widgets con totales y resúmenes
- **Importación:** Afiliados y proveedores desde Excel

---

## Convenciones del proyecto

### Filament Resources
Cada Resource sigue la estructura:
```
app/Filament/Resources/{Entidad}s/
├── {Entidad}Resource.php          # Configuración del resource
├── Pages/                         # List, Create, Edit
├── Schemas/{Entidad}Form.php      # Definición del formulario
└── Tables/{Entidad}sTable.php     # Definición de la tabla
```

### NavigationGroup
- `'Afiliados'` — Afiliados
- `'Proveedores'` — Proveedores, Tipos de Proveedor
- `'Órdenes'` — Órdenes, Códigos de Operación
- `'Farmacia'` — Movimientos Farmacia
- `'Reintegros'` — Reintegros, Tipos de Reintegro
- `'Configuración'` — Zonas, Condiciones
- `'Usuarios'` — Users, Roles

### NavigationGroup en Resources (Filament 5)
El tipo correcto para `$navigationGroup` en Filament 5 es:
```php
protected static \UnitEnum|string|null $navigationGroup = 'Nombre del grupo';
```

### Idioma
El sistema está en español. `APP_LOCALE=es`. Las traducciones de Filament están publicadas en `lang/vendor/filament*/es/`. Los labels de campos y columnas se definen siempre con `->label('Texto en español')`.

### Seeders
Ejecutar el seeder inicial con:
```bash
docker exec suoem_app php artisan db:seed --class=ZonasCondicionesSeeder
```

---

## Preguntas pendientes con el cliente

1. ¿Qué datos adicionales necesita el afiliado? (DNI, fecha nacimiento, dirección, email, fecha ingreso)
2. ¿Puede un afiliado tener múltiples órdenes activas? ¿Hay límite de endeudamiento?
3. ¿Qué pasa con las órdenes activas si un afiliado se da de baja?
4. ¿El número de orden es único global o reinicia por año?
5. ¿Una orden puede ser anulada? ¿Qué pasa con cuotas ya descontadas?
6. ¿Hay proceso de aprobación antes de liquidar a una farmacia?
7. ¿El número de reintegro reinicia cada año o es único histórico?
8. ¿Cuáles son los estados del reintegro? (Pendiente → En Contaduría → Transferido → Rechazado)
9. ¿Existe monto máximo de reintegro por tipo o período?
10. ¿Qué roles de usuario va a haber? (Administrador, Operador, Solo lectura)
11. ¿El sistema se usa desde una sola sede o varias?
12. ¿Necesita integrarse con el sistema de liquidación de sueldos municipal?
13. ¿Los reportes deben exportarse a Excel y/o PDF?
